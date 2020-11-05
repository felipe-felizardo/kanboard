<?php

require_once __DIR__.'/../Base.php';

use Kanboard\Event\TaskEvent;
use Kanboard\Model\TaskCreationModel;
use Kanboard\Model\TaskFinderModel;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;
use Kanboard\Action\TaskAssignPriorityColumn;

class TaskAssignPriorityColumnTest extends Base
{
    public function testChangeColumn()
    {
        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test', 'priority' => 1)));

        $task = $taskFinderModel->getById(1);
        $this->assertNotEmpty($task);
        $this->assertEquals(1, $task['priority']);				
				
        $event = new TaskEvent(array(
            'task_id' => 1,
            'task' => array(
                'project_id' => 1,
                'column_id' => 2,
            )
        ));

        $action = new TaskAssignPriorityColumn($this->container);
        $action->setProjectId(1);
        $action->setParam('priority', 2);
        $action->setParam('column_id', 2);

        $this->assertTrue($action->execute($event, TaskModel::EVENT_MOVE_COLUMN));

        $task = $taskFinderModel->getById(1);
        $this->assertNotEmpty($task);
        $this->assertEquals(2, $task['priority']);
    }
}
