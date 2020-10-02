<div class="tooltip-large">
    <table class="table-small">
        <tr>
            <th class="column-40"><?= t('Subtask') ?></th>
            <th class="column-40"><?= t('Status') ?></th>
            <?= $this->hook->render('template:board:tooltip:subtasks:header:before-assignee') ?>
            <th><?= t('Assignee') ?></th>
        </tr>
        <?php foreach ($subtasks as $subtask): ?>
        <tr>
            <td>
                <?= $this->url->link(
                    $this->text->e($subtask['title']),
                    'SubtaskController',
                    'show',                           
                    array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'editable' => false, 'subtask_id' => $subtask['id'])) ?>
            </td>
            <td>
                <?= $this->subtask->getSubtaskTooltip($subtask) ?> 
            </td>
            <?= $this->hook->render('template:board:tooltip:subtasks:rows', array('subtask' => $subtask)) ?>
            <td>
                <?php if (! empty($subtask['username'])): ?>
                    <?= $this->text->e($subtask['name'] ?: $subtask['username']) ?>
                <?php else: ?>
                    <?= t('Not assigned') ?>
                <?php endif ?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
