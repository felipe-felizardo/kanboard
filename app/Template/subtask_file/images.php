<?php if (! empty($images)): ?>
    <div class="file-thumbnails">
        <?php foreach ($images as $file): ?>
            <div class="file-thumbnail">
                <?= $this->app->component('image-slideshow', array(
                    'images' => $images,
                    'image' => $file,
                    'regex' => 'FILE_ID',
                    'url' => array(
                        'image' => $this->url->to('FileViewerController', 'image', array('file_id' => 'FILE_ID', 'project_id' => $task['project_id'], 'task_id' => $task['id'], 'subtask_id' => $subtask['id'])),
                        'thumbnail' => $this->url->to('FileViewerController', 'thumbnail', array('file_id' => 'FILE_ID', 'project_id' => $task['project_id'], 'task_id' => $task['id'], 'subtask_id' => $subtask['id'])),
                        'download' => $this->url->to('FileViewerController', 'download', array('file_id' => 'FILE_ID', 'project_id' => $task['project_id'], 'task_id' => $task['id'], 'subtask_id' => $subtask['id'])),
                    )
                )) ?>

                <div class="file-thumbnail-content">
                    <div class="file-thumbnail-title">
                        <div class="dropdown">
                            <a href="#" class="dropdown-menu dropdown-menu-link-text" title="<?= $this->text->e($file['name']) ?>"><?= $this->text->e($file['name']) ?> <i class="fa fa-caret-down"></i></a>
                            <ul>
                                <li>
                                    <?= $this->url->icon('external-link', t('View file'), 'FileViewerController', 'image', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'file_id' => $file['id']), false, '', '', true) ?>
                                </li>
                                <li>
                                    <?= $this->url->icon('download', t('Download'), 'FileViewerController', 'download', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'file_id' => $file['id'])) ?>
                                </li>
                                <?php if ($this->user->hasProjectAccess('SubtaskFileController', 'remove', $task['project_id'])): ?>
                                    <li>
                                        <?= $this->modal->confirm('trash-o', t('Remove'), 'SubtaskFileController', 'confirm', array('subtask_id' => $subtask['id'], 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'file_id' => $file['id'])) ?>
                                    </li>
                                <?php endif ?>
                                <?= $this->hook->render('template:task-file:images:dropdown', array('task' => $task, 'file' => $file)) ?>
                            </ul>
                        </div>
                    </div>
                    <div class="file-thumbnail-description">
                        <?= $this->hook->render('template:task-file:images:before-thumbnail-description', array('task' => $task, 'file' => $file)) ?>
                        <?= $this->app->tooltipMarkdown(t('Uploaded: %s', $this->dt->datetime($file['date']))."\n\n".t('Size: %s', $this->text->bytes($file['size']))) ?>
                        <?php if (! empty($file['user_id'])): ?>
                            <?= t('Uploaded by %s', $file['user_name'] ?: $file['username']) ?>
                        <?php else: ?>
                            <?= t('Uploaded: %s', $this->dt->datetime($file['date'])) ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>