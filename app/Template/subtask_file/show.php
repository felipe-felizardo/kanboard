<details class="accordion-section" <?= empty($files) && empty($images) ? '' : 'open' ?>>
    <summary class="accordion-title"><?= t('Attachments') ?></summary>
    <div class="accordion-content">
        <?= $this->render('subtask_file/images', array('subtask' => $subtask, 'task' => $task, 'images' => $images)) ?>
        <?= $this->render('subtask_file/files', array('subtask' => $subtask, 'task' => $task, 'files' => $files)) ?>
    </div>
    <?= $this->modal->mediumButton('file', t('Attach a document'), 'SubtaskFileController', 'create', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
</details>
