<?= $this->hook->render('template:task:show:top', array('task' => $task, 'project' => $project)) ?>

<?= $this->render('subtask_view/details', array(
    'subtask' => $subtask,
    'task' => $task,
    'editable' => $this->user->hasProjectAccess('TaskModificationController', 'edit', $project['id']),
)) ?>

<?= $this->hook->render('template:task:show:before-description', array('task' => $task, 'project' => $project)) ?>
<?= $this->render('subtask_view/description', array('subtask' => $subtask)) ?>

<?= $this->render('activity/project', array(
    'title'   => t('%s\'s activity', $project['name']),
    'events'  => $this->helper->projectActivity->getProjectEvents($project['id']),
    'project' => $project 
)) ?>

<?= $this->hook->render('template:task:show:bottom', array('task' => $task, 'project' => $project)) ?>
