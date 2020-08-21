<div class="page-header">
    <h2><?= t('Close project\'s scope') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to close the project\'s scope: "%s"?', $project['name']) ?>
    </p>

    <?= $this->modal->confirmButtons(
        'ProjectScopeController',
        'close',
        array('project_id' => $project['id'])
    ) ?>
</div>
