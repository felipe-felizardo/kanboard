<div class="table-list-header">
    <div class="table-list-header-count">
        <?php if ($paginator->getTotal() > 1): ?>
            <?= t('%d backlogs', $paginator->getTotal()) ?>
        <?php else: ?>
            <?= t('%d backlog', $paginator->getTotal()) ?>
        <?php endif ?>
    </div>
    <div class="table-list-header-menu">
        <?= $this->render('project_list/sort_menu', array('paginator' => $paginator)) ?>
    </div>
</div>
