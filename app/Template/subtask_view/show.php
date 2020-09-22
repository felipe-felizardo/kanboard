<?= $this->hook->render('template:task:show:top', array('task' => $task, 'project' => $project)) ?>

<?= $this->render('subtask_view/details', array(
    'subtask' => $subtask,
    'task' => $task,
    'editable' => $this->user->hasProjectAccess('TaskModificationController', 'edit', $project['id']),
)) ?>

<?= $this->hook->render('template:task:show:before-description', array('task' => $task, 'project' => $project)) ?>
<?= $this->render('subtask_view/description', array('subtask' => $subtask)) ?>

<?= $this->render('activity/subtask', array(
    'title'   => $subtask['title'],
    'events'  => $this->helper->projectActivity->getSubtaskEvents($subtask['id']))) ?>

<?= $this->hook->render('template:task:show:bottom', array('task' => $task, 'project' => $project)) ?>
