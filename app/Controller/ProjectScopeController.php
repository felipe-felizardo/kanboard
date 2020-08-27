<?php

namespace Kanboard\Controller;

/**
 * Class ProjectScopeController
 *
 * @package Kanboard\Controller
 * @author  Felipe Felizardo Gonçalves
 */
class ProjectScopeController extends BaseController
{
    /**
     * Open project's scope (confirmation dialog box)
     */
    public function confirmOpen()
    {
        $project = $this->getProject();

        $this->response->html($this->template->render('project_scope/open', array(
            'project' => $project,
        )));
    }

    /**
     * Open project's scope
     */
    public function open()
    {
        $project = $this->getProject();
        $this->checkCSRFParam();

        if ($this->projectModel->openScope($project['id'])) {
            $this->flash->success(t('Project\'s scope opened successfully.'));
        } else {
            $this->flash->failure(t('Unable to open project\'s scope.'));
        }

        $this->response->redirect($this->helper->url->to('ProjectViewController', 'show', array('project_id' => $project['id'])), true);
    }

    /**
     * Close project's scope (confirmation dialog box)
     */
    public function confirmClose()
    {
        $project = $this->getProject();

        $this->response->html($this->template->render('project_scope/close', array(
            'project' => $project,
        )));
    }

    /**
     * Close project's scope
     */
    public function close()
    {
        $project = $this->getProject();
        $this->checkCSRFParam();
        if ($this->projectModel->tasksEstimatedHours($project['id']) <= $project['hour_budget'])
        {
            if ($this->projectModel->closeScope($project['id'])) {
                $this->flash->success(t('Project\'s scope closed successfully.'));
            } else {
                $this->flash->failure(t('Unable to close project\'s scope.'));
            }
        } else {
            $this->flash->failure(t('Project\'s scope cannot close because the provisioned programming hours is greater than provision hours.'));
        }        

        $this->response->redirect($this->helper->url->to('ProjectViewController', 'show', array('project_id' => $project['id'])), true);
    }
}
