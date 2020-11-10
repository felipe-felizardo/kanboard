<div class="sidebar">
    <?= $this->app->component('select-dropdown-autocomplete', array(
        'name' => 'user_id',
        'items' => $users,
        'defaultValue' => $filter['user_id'],
        'sortByKeys' => true,
        'redirect' => array(
            'regex' => 'USER_ID',
            'url' => $this->url->to('ProjectUserOverviewController', $this->app->getRouterAction(), array('user_id' => 'USER_ID')),
        ),
    )) ?>

    <br>

    <ul>
        <li <?= $this->app->checkMenuSelection('ProjectUserOverviewController', 'managers') ?>>
            <?= $this->url->link(t('Project managers'), 'ProjectUserOverviewController', 'managers', $filter) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('ProjectUserOverviewController', 'testers') ?>>
            <?= $this->url->link(t('Project testers'), 'ProjectUserOverviewController', 'testers', $filter) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('ProjectUserOverviewController', 'developers') ?>>
            <?= $this->url->link(t('Project developers'), 'ProjectUserOverviewController', 'developers', $filter) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('ProjectUserOverviewController', 'opens') ?>>
            <?= $this->url->link(t('Open tasks'), 'ProjectUserOverviewController', 'opens', $filter) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('ProjectUserOverviewController', 'closed') ?>>
            <?= $this->url->link(t('Closed tasks'), 'ProjectUserOverviewController', 'closed', $filter) ?>
        </li>

        <?= $this->hook->render('template:project-user:sidebar') ?>
    </ul>
</div>
