<div class="page-header">
    <h2><?= $this->subtask->getSubtaskActionStatusChange($status) ?></h2>
</div>

<form method="post" action="<?= $this->url->href('SubtaskStatusController', 'toggleEnd', array('status' => $status, 'task_id' => $task['id'], 'subtask_id' => $subtask_id, 'values' => $values)) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->label('Comentários:', 'comment') ?>

    <?= $this->form->textEditor('comment', $values, $errors, array('required' => true)) ?>

    <?= $this->modal->submitButtons() ?>
</form>