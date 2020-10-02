<section id="main">
    <?= $this->projectHeader->render($project, 'TaskListController', 'show', false, array('task' => $task)) ?>
    <?= $this->hook->render('template:task:layout:top', array('task' => $task)) ?>
    <section class="sidebar-container" id="task-view">
        <div class="sidebar-content">
            <?= $content_for_sublayout ?>
        </div>
    </section>
</section>
