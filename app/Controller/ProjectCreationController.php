<?php

namespace Kanboard\Controller;

/**
 * Project Creation Controller
 *
 * @package  Kanboard\Controller
 * @author   Frederic Guillot
 */
class ProjectCreationController extends BaseController
{
    /**
     * Display a form to create a new project
     *
     * @access public
     * @param array $values
     * @param array $errors
     */
    public function create(array $values = array(), array $errors = array())
    {
        $is_private = isset($values['is_private']) && $values['is_private'] == 1;
        $projects_list = array(0 => t('Do not duplicate anything')) + $this->projectUserRoleModel->getActiveProjectsByUser($this->userSession->getId());
        if (!isset($values['hour_budget']))
            $values['hour_budget'] = 0;

        if (!isset($values['start_date']))
            $values['start_date'] = date($this->dateParser->getUserDateFormat());

        if (!isset($values['end_date']))
            $values['end_date'] = date($this->dateParser->getUserDateFormat());            

        $this->response->html($this->helper->layout->app('project_creation/create', array(
            'values' => $values,
            'errors' => $errors,
            'is_private' => $is_private,
            'projects_list' => $projects_list,
            'title' => $is_private ? t('New personal project') : t('New project'),
        )));
    }

    /**
     * Display a form to create a backlog project
     *
     * @access public
     * @param array $values
     * @param array $errors
     */
    public function createBacklog(array $values = array(), array $errors = array())
    {
        $values['is_backlog'] = 1;
        $projects_list = array(0 => t('Do not duplicate anything')) + $this->projectUserRoleModel->getActiveProjectsByUser($this->userSession->getId());

        $this->response->html($this->helper->layout->app('project_creation/create_backlog', array(
            'values' => $values,
            'errors' => $errors,
            'projects_list' => $projects_list,
            'title' => t('New backlog'),
        )));
    }

    /**
     * Display a form to create a private project
     *
     * @access public
     * @param array $values
     * @param array $errors
     */
    public function createPrivate(array $values = array(), array $errors = array())
    {
        $values['is_private'] = 1;
        $this->create($values, $errors);
    }

    /**
     * Validate and save a new project
     *
     * @access public
     */
    public function save()
    {
        $values = $this->request->getValues();
        list($valid, $errors) = $this->projectValidator->validateCreation($values);

        if ($valid) {
            $project_id = $this->createOrDuplicate($values);

            if ($project_id > 0) {
                $this->flash->success(t('Your project has been created successfully.'));
                return $this->response->redirect($this->helper->url->to('ProjectViewController', 'show', array('project_id' => $project_id)));
            }

            $this->flash->failure(t('Unable to create your project.'));
        }
        if (!isset($values['id']))
            return $this->create($values, $errors);
        else
            return $this->createBacklog($values, $errors);
    }

    /**
     * Create or duplicate a project
     *
     * @access private
     * @param  array  $values
     * @return boolean|integer
     */
    private function createOrDuplicate(array $values)
    {
        if (!$this->projectModel->exists(1)) {
            return $this->createNewProject($values);
        }

        return $this->duplicateNewProject($values);
    }

    /**
     * Save a new project
     *
     * @access private
     * @param  array  $values
     * @return boolean|integer
     */
    private function createNewProject(array $values)
    {
        $project = array(
            'name' => $values['name'],
            'is_private' => $values['is_private'],
            'identifier' => $values['identifier'],
            'per_swimlane_task_limits' => array_key_exists('per_swimlane_task_limits', $values) ? $values['per_swimlane_task_limits'] : 0,
            'task_limit' => $values['task_limit'],
            'hour_budget' => $values['hour_budget'],
        );

        return $this->projectModel->create($project, $this->userSession->getId(), true);
    }

    /**
     * Create from another project
     *
     * @access private
     * @param  array  $values
     * @return boolean|integer
     */
    private function duplicateNewProject(array $values)
    {
        if (!isset($values['hour_budget']))
            $values['hour_budget'] = 0;

        if (!isset($values['is_private']))
            $values['is_private'] = 0;

        if (!isset($values['is_backlog']))
            $values['is_backlog'] = 0;

        if (!isset($values['id']))
        {
            $values['id'] = 0;
            $values['src_project_id'] = '1';
        }
        else
            $values['src_project_id'] = '2';
            
        //Allways duplicate the below data to the new project
        $values['projectPermissionModel'] = '1';
        $values['projectRoleModel'] = '1';
        $values['categoryModel'] = '1';
        $values['tagDuplicationModel'] = '1';
        $values['actionModel'] = '1';
        $values['customFilterModel'] = '1';

        $selection = array();

        foreach ($this->projectDuplicationModel->getOptionalSelection() as $item) {
            if (isset($values[$item]) && $values[$item] == 1) {
                $selection[] = $item;
            }
        }

        return $this->projectDuplicationModel->duplicate(
            $values['src_project_id'],
            $selection,
            $this->userSession->getId(),
            $values['name'],
            $values['is_private'] == 1,
            $values['identifier'],
            $values['hour_budget'],
            $values['id'],
            $values['is_backlog'] == 1,
            $values['start_date'],
            $values['end_date'],
        );
    }
}
