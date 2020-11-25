<?php

namespace Kanboard\Controller;

/**
 * Subtask File Controller
 *
 * @package  Kanboard\Controller
 * @author   Frederic Guillot
 */
class SubtaskFileController extends BaseController
{
    /**
     * Screenshot
     *
     * @access public
     */
    public function screenshot()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);

        if ($this->request->isPost() && $this->subtaskFileModel->uploadScreenshot($subtask['id'], $this->request->getValue('screenshot')) !== false) {
            $this->flash->success(t('Screenshot uploaded successfully.'));
            return $this->response->redirect($this->helper->url->to('TaskViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])), true);
        }

        return $this->response->html($this->template->render('task_file/screenshot', array(
            'task' => $task,
        )));
    }

    /**
     * File upload form
     *
     * @access public
     */
    public function create()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);

        $this->response->html($this->template->render('subtask_file/create', array(
            'task' => $task,
            'subtask' => $subtask,
            'max_size' => $this->helper->text->phpToBytes(get_upload_max_size()),
        )));
    }

    /**
     * File upload (save files)
     *
     * @access public
     */
    public function save()
    {
        $this->checkReusableCSRFParam();
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $result = $this->subtaskFileModel->uploadFiles($subtask['id'], $this->request->getFileInfo('files'));

        if ($this->request->isAjax()) {
            if (! $result) {
                $this->response->json(array('message' => t('Unable to upload files, check the permissions of your data folder.')), 500);
            } else {
                $this->response->json(array('message' => 'OK'));
            }
        } else {
            if (! $result) {
                $this->flash->failure(t('Unable to upload files, check the permissions of your data folder.'));
            }

            $this->response->redirect($this->helper->url->to('SubtaskController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])), true);
        }
    }

    /**
     * Remove a file
     *
     * @access public
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $file = $this->subtaskFileModel->getById($this->request->getIntegerParam('file_id'));

        if ($file['subtask_id'] == $subtask['id'] && $this->subtaskFileModel->remove($file['id'])) {
            $this->flash->success(t('File removed successfully.'));
        } else {
            $this->flash->failure(t('Unable to remove this file.'));
        }

        $this->response->redirect($this->helper->url->to('SubtaskController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])), true);
    }

    /**
     * Confirmation dialog before removing a file
     *
     * @access public
     */
    public function confirm()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $file = $this->subtaskFileModel->getById($this->request->getIntegerParam('file_id'));

        $this->response->html($this->template->render('subtask_file/remove', array(
            'task' => $task,
            'subtask' => $subtask,
            'file' => $file,
        )));
    }
}
