<?php

use Kanboard\Model\ProjectModel;
use Kanboard\Model\SubtaskModel;
use Kanboard\Model\SubtaskStatusModel;
use Kanboard\Model\TaskCreationModel;

require_once __DIR__.'/../Base.php';

class SubtaskStatusModelTest extends Base
{
    public function testToggleStatusWithoutSession()
    {
        $taskCreationModel = new TaskCreationModel($this->container);
        $subtaskModel = new SubtaskModel($this->container);
        $subtaskStatusModel = new SubtaskStatusModel($this->container);
        $projectModel = new ProjectModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('title' => 'test 1', 'project_id' => 1)));

        $this->assertEquals(1, $subtaskModel->create(array('title' => 'subtask #1', 'task_id' => 1)));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TODO, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_DEV_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_STOPPED, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_DEV_STOPPED));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_STOPPED, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_DEV_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_DONE, $subtaskStatusModel->toggleStatus(1, SubtaskModel::STATUS_DEV_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_DONE, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_STOPPED, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_STOPPED));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_STOPPED, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_FAILED, $subtaskStatusModel->toggleStatus(1, SubtaskModel::STATUS_TEST_FAILED));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_FAILED, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DONE, $subtaskStatusModel->toggleStatus(1, SubtaskModel::STATUS_DONE));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DONE, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);
    }

    public function testToggleStatusWithSession()
    {
        $taskCreationModel = new TaskCreationModel($this->container);
        $subtaskModel = new SubtaskModel($this->container);
        $projectModel = new ProjectModel($this->container);
        $subtaskStatusModel = new SubtaskStatusModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('title' => 'test 1', 'project_id' => 1)));

        $this->assertEquals(1, $subtaskModel->create(array('title' => 'subtask #1', 'task_id' => 1)));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TODO, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        // Set the current logged user
        $_SESSION['user'] = array('id' => 1);

        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_DEV_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_STOPPED, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_DEV_STOPPED));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_STOPPED, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_DEV_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DEV_DONE, $subtaskStatusModel->toggleStatus(1, SubtaskModel::STATUS_DEV_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DEV_DONE, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_STOPPED, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_STOPPED));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_STOPPED, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_FAILED, $subtaskStatusModel->toggleStatus(1, SubtaskModel::STATUS_TEST_FAILED));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_FAILED, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtaskStatusModel->toggle(1, SubtaskModel::STATUS_TEST_INPROGRESS));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_TEST_INPROGRESS, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);

        $this->assertEquals(SubtaskModel::STATUS_DONE, $subtaskStatusModel->toggleStatus(1, SubtaskModel::STATUS_DONE));

        $subtask = $subtaskModel->getById(1);
        $this->assertNotEmpty($subtask);
        $this->assertEquals(SubtaskModel::STATUS_DONE, $subtask['status']);
        $this->assertEquals(0, $subtask['user_id']);
        $this->assertEquals(1, $subtask['task_id']);
    }

    public function testCloseAll()
    {
        $taskCreationModel = new TaskCreationModel($this->container);
        $subtaskModel = new SubtaskModel($this->container);
        $projectModel = new ProjectModel($this->container);
        $subtaskStatusModel = new SubtaskStatusModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('title' => 'test 1', 'project_id' => 1)));

        $this->assertEquals(1, $subtaskModel->create(array('title' => 'subtask #1', 'task_id' => 1)));
        $this->assertEquals(2, $subtaskModel->create(array('title' => 'subtask #2', 'task_id' => 1)));

        $this->assertTrue($subtaskStatusModel->closeAll(1));

        $subtasks = $subtaskModel->getAll(1);
        $this->assertNotEmpty($subtasks);

        foreach ($subtasks as $subtask) {
            $this->assertEquals(SubtaskModel::STATUS_DONE, $subtask['status']);
        }
    }
}
