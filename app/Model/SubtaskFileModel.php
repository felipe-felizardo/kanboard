<?php

namespace Kanboard\Model;

/**
 * Subtask File Model
 *
 * @package  Kanboard\Model
 * @author   Felipe Felizardo Gonçalves
 */
class SubtaskFileModel extends FileModel
{
    /**
     * Table name
     *
     * @var string
     */
    const TABLE = 'subtask_has_files';

    /**
     * Events
     *
     * @var string
     */
    const EVENT_CREATE = 'subtask.file.create';
    const EVENT_DESTROY = 'subtask.file.destroy';

    /**
     * Get the table
     *
     * @abstract
     * @access protected
     * @return string
     */
    protected function getTable()
    {
        return self::TABLE;
    }

    /**
     * Define the foreign key
     *
     * @abstract
     * @access protected
     * @return string
     */
    protected function getForeignKey()
    {
        return 'subtask_id';
    }

    /**
     * Define the path prefix
     *
     * @abstract
     * @access protected
     * @return string
     */
    protected function getPathPrefix()
    {
        return 'subtasks';
    }

    /**
     * Get projectId from fileId
     *
     * @access public
     * @param  integer $file_id
     * @return integer
     */
    public function getProjectId($file_id)
    {
        $task_id = $this->getTaskId($file_id);    
        return $this->db
            ->table(TaskModel::TABLE)
            ->eq(TaskModel::TABLE.'.id', $task_id)
            ->findOneColumn(TaskModel::TABLE . '.project_id') ?: 0;
    }

    /**
     * Get taskId from fileId
     *
     * @access public
     * @param  integer $file_id
     * @return integer
     */
    public function getTaskId($file_id)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq(self::TABLE.'.id', $file_id)
            ->join(SubtaskModel::TABLE, 'id', 'subtask_id')
            ->findOneColumn(SubtaskModel::TABLE . '.task_id') ?: 0;
    }    

    /**
     * Handle screenshot upload
     *
     * @access public
     * @param  integer  $subtask_id   SubTask id
     * @param  string   $blob         Base64 encoded image
     * @return bool|integer
     */
    public function uploadScreenshot($subtask_id, $blob)
    {
        $original_filename = e('Screenshot taken %s', $this->helper->dt->datetime(time())).'.png';
        return $this->uploadContent($subtask_id, $original_filename, $blob);
    }

    /**
     * Fire file creation event
     *
     * @access protected
     * @param  integer $file_id
     */
    protected function fireCreationEvent($file_id)
    {
        $this->queueManager->push($this->taskFileEventJob->withParams($file_id, self::EVENT_CREATE));
    }

    /**
     * Fire file destruction event
     *
     * @access protected
     * @param  integer $file_id
     */
    protected function fireDestructionEvent($file_id)
    {
        $this->queueManager->push($this->taskFileEventJob->withParams($file_id, self::EVENT_DESTROY));
    }
}
