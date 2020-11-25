<div class="sidebar">
    <ul>
        <li <?= $this->app->checkMenuSelection('ProjectViewController', 'show') ?>>
            <?= $this->url->link(t('Summary'), 'ProjectViewController', 'show', array('project_id' => $project['id'])) ?>
        </li>
        <?php if ($this->user->hasProjectAccess('CustomFilterController', 'index', $project['id'])): ?>
        <li <?= $this->app->checkMenuSelection('CustomFilterController') ?>>
            <?= $this->url->link(t('Custom filters'), 'CustomFilterController', 'index', array('project_id' => $project['id'])) ?>
        </li>
        <?php endif ?>

        <?php if ($this->user->hasProjectAccess('ProjectEditController', 'show', $project['id'])): ?>
            <li <?= $this->app->checkMenuSelection('ProjectEditController') ?>>
                <?= $this->url->link(t('Edit project'), 'ProjectEditController', 'show', array('project_id' => $project['id'])) ?>
            </li>
            <li <?= $this->app->checkMenuSelection('ProjectViewController', 'share') ?>>
                <?= $this->url->link(t('Public access'), 'ProjectViewController', 'share', array('project_id' => $project['id'])) ?>
            </li>
            <?php if ($this->user->hasProjectAccess('ProjectViewController', 'integrations', $project['id'])): ?>
            <?php endif ?>
            <?php if ($this->user->hasProjectAccess('ColumnController', 'index', $project['id'])): ?>            
            <li <?= $this->app->checkMenuSelection('ColumnController') ?>>
                <?= $this->url->link(t('Columns'), 'ColumnController', 'index', array('project_id' => $project['id'])) ?>
            </li>
            <?php endif ?>
            <?php if ($this->user->hasProjectAccess('SwimlaneController', 'index', $project['id'])): ?>
            <li <?= $this->app->checkMenuSelection('SwimlaneController') ?>>
                <?= $this->url->link(t('Swimlanes'), 'SwimlaneController', 'index', array('project_id' => $project['id'])) ?>
            </li>
            <?php endif ?>
            <li <?= $this->app->checkMenuSelection('CategoryController') ?>>
                <?= $this->url->link(t('Categories'), 'CategoryController', 'index', array('project_id' => $project['id'])) ?>
            </li>
            <li <?= $this->app->checkMenuSelection('ProjectTagController') ?>>
                <?= $this->url->link(t('Tags'), 'ProjectTagController', 'index', array('project_id' => $project['id'])) ?>
            </li>
            <?php if ($project['is_private'] == 0): ?>
            <li <?= $this->app->checkMenuSelection('ProjectPermissionController') ?>>
                <?= $this->url->link(t('Permissions'), 'ProjectPermissionController', 'index', array('project_id' => $project['id'])) ?>
            </li>
            <?php endif ?>
            <?php if ($this->user->hasProjectAccess('ActionController', 'index', $project['id'])): ?>
            <li <?= $this->app->checkMenuSelection('ActionController') ?>>
                <?= $this->url->link(t('Automatic actions'), 'ActionController', 'index', array('project_id' => $project['id'])) ?>
            </li>
            <?php endif ?>
            <?php if ($this->user->hasProjectAccess('ProjectViewController', 'duplicate', $project['id'])): ?>
            <li <?= $this->app->checkMenuSelection('ProjectViewController', 'duplicate') ?>>
                <?= $this->url->link(t('Duplicate'), 'ProjectViewController', 'duplicate', array('project_id' => $project['id'])) ?>
            </li>
            <?php endif ?>
            <li>
                <?php if ($project['scope_is_open']): ?>               
                    <?= $this->modal->confirmLink(t('Close project\'s scope'), 'ProjectScopeController', 'confirmClose', array('project_id' => $project['id'])) ?>
                <?php else: ?>
                    <?= $this->modal->confirmLink(t('Reopen project\'s scope'), 'ProjectScopeController', 'confirmOpen', array('project_id' => $project['id'])) ?>
                <?php endif ?>
            </li>     
            <li>
                <?php if ($project['is_active']): ?>             
                    <?= $this->modal->confirmLink(t('Close this project'), 'ProjectStatusController', 'confirmDisable', array('project_id' => $project['id'])) ?>
                <?php else: ?>
                    <?= $this->modal->confirmLink(t('Open this project'), 'ProjectStatusController', 'confirmEnable', array('project_id' => $project['id'])) ?>
                <?php endif ?>
            </li>
            <?php if ($this->user->hasProjectAccess('ProjectStatusController', 'remove', $project['id'])): ?>
                <li>
                    <?= $this->modal->confirmLink(t('Remove'), 'ProjectStatusController', 'confirmRemove', array('project_id' => $project['id'])) ?>
                </li>
            <?php endif ?>
        <?php endif ?>

        <?= $this->hook->render('template:project:sidebar', array('project' => $project)) ?>
    </ul>
</div>
