<section id="main">
    <div class="page-header">
        <h2><?= $title ?></h2>
    </div>
    <form id="project-creation-form" method="post" action="<?= $this->url->href('ProjectCreationController', 'save') ?>" autocomplete="off">

        <?= $this->form->csrf() ?>
        <?= $this->form->hidden('is_private', $values) ?>

        <?= $this->form->label(t('Name'), 'name') ?>
        <?= $this->form->text('name', $values, $errors, array('autofocus', 'required')) ?>

        <?= $this->form->label(t('Identifier'), 'identifier') ?>
        <?= $this->form->text('identifier', $values, $errors, array('autofocus')) ?>
        <p class="form-help"><?= t('The project identifier is optional and must be alphanumeric, example: MYPROJECT.') ?></p>

        <?= $this->form->date(t('Start date'), 'start_date', $values, $errors) ?>
        <?= $this->form->date(t('End date'), 'end_date', $values, $errors) ?>

        <?= $this->form->label(t('Programming hours budget'), 'hour_budget') ?>
        <?= $this->form->number('hour_budget', $values, $errors, array('autofocus', 'required')) ?>

        <?= $this->modal->submitButtons() ?>
    </form>
    <?php if ($is_private): ?>
    <div class="alert alert-info">
        <p><?= t('There is no user management for personal projects.') ?></p>
    </div>
    <?php endif ?>
</section>
