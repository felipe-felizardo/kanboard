<?php

use Kanboard\Action\SubtaskCreationTaskCreationColumn;
use Kanboard\EventBuilder\TaskEventBuilder;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskCreationModel;
use Kanboard\Model\TaskFinderModel;
use Kanboard\Model\TaskModel;

require_once __DIR__.'/../Base.php';

class SubtaskCreationTaskCreationColumnTest extends Base
{
    public function testAction()
    {
        $projectModel = new ProjectModel($this->container);
        $subtaskModel = new SubtaskModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $event = TaskEventBuilder::getInstance($this->container)
            ->withTaskId(1)
            ->buildEvent();

        $action = new SubtaskCreationTaskCreationColumn($this->container);
        $action->setProjectId(1);
        $action->setParam('column_id', 1);
        $action->setParam('subtask', 'Subtask');

        $this->assertTrue($action->execute($event, TaskModel::EVENT_CREATE));

        $task = $taskFinderModel->getById(1);
        $this->assertNotEmpty($task);
        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
    }
}
