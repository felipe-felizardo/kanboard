<section id="main">
    <div class="page-header">
        <h2><?= $title ?></h2>
    </div>
    <form id="project-creation-form" method="post" action="<?= $this->url->href('ProjectCreationController', 'save') ?>" autocomplete="off">

        <?= $this->form->csrf() ?>
        <?= $this->form->hidden('is_backlog', $values) ?>

        <?= $this->form->label(t('Id of the backlog (3 ~ 999)'), 'id') ?>
        <?= $this->form->number('id', $values, $errors, array('autofocus')) ?>

        <?= $this->form->label(t('Name'), 'name') ?>
        <?= $this->form->text('name', $values, $errors, array('autofocus', 'required')) ?>

        <?= $this->form->label(t('Identifier'), 'identifier') ?>
        <?= $this->form->text('identifier', $values, $errors, array('autofocus')) ?>
        <p class="form-help"><?= t('The project identifier is optional and must be alphanumeric, example: MYPROJECT.') ?></p>

        <?= $this->modal->submitButtons() ?>
    </form>
</section>
