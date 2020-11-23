<?= $this->hook->render('template:task:show:top', array('task' => $task, 'project' => $project)) ?>

<div class="page-header project-link">
    <h2>
        <span>
            <?= e('Solicitação %s / %s',
                $this->url->link(t('#%d', $task['id']), 'TaskViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])),
                $this->text->e($subtask['title'])
            ) ?> 
        </span>
    </h2>
</div>

<?= $this->render('subtask_view/details', array(
    'subtask' => $subtask,
    'task' => $task,
    'editable' => $this->user->hasProjectAccess('TaskModificationController', 'edit', $project['id']),
)) ?>

<?= $this->render('activity/subtask', array(
    'title'   => $subtask['title'],
    'events'  => $this->helper->projectActivity->getSubtaskEvents($subtask['id']))) ?>

<?= $this->hook->render('template:task:show:bottom', array('task' => $task, 'project' => $project)) ?>
