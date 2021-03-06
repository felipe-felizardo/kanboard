<?php if (! empty($subtasks)): ?>
    <table
        class="subtasks-table table-striped table-scrolling"
        data-save-position-url="<?= $this->url->href('SubtaskController', 'movePosition', array('project_id' => $task['project_id'], 'task_id' => $task['id'])) ?>"
    >
    <thead>
        <tr>
            <th class="column-30"><?= t('Title') ?></th>
            <th class="column-20"><?= t('Status') ?></th>
            <th class="column-20"><?= t('Assignee') ?></th>
            <?= $this->hook->render('template:subtask:table:header:before-timetracking') ?>
            <th class="column-30"><?= t('Time tracking') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subtasks as $subtask): ?>
        <tr data-subtask-id="<?= $subtask['id'] ?>">
            <td>
                <div class="subtask-table-td">
                <?php if ($editable): ?>
                        <i class="fa fa-arrows-alt draggable-row-handle" title="<?= t('Change subtask position') ?>"></i>&nbsp;
                        <?= $this->render('subtask/menu', array(
                            'task' => $task,
                            'subtask' => $subtask,
                        )) ?>
                <?php endif ?>
                    <span class="subtask-title">
                        <?= $this->url->link(
                            $this->text->e($subtask['title']),
                            'SubtaskController',
                            'show',
                            array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'editable' => $editable, 'subtask_id' => $subtask['id'])) ?>
                    </span>
                </div>
            </td>
            <td>
                <div class="subtask-table-td">
                    <strong>
                        <?= $this->subtask->renderStatus($subtask) ?>
                    </strong>
                    <?= $this->subtask->renderChooseStatus($task, $subtask) ?>
                </div> 
            </td>          
            <td>
                <?php if (! empty($subtask['username'])): ?>
                    <?= $this->text->e($subtask['name'] ?: $subtask['username']) ?>
                <?php endif ?>
            </td>
            <?= $this->hook->render('template:subtask:table:rows', array('subtask' => $subtask)) ?>
            <td>
                <?= $this->render('subtask/timer', array(
                    'task'    => $task,
                    'subtask' => $subtask,
                )) ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
    </table>
<?php endif ?>
