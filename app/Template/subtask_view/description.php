<details class="accordion-section" <?= empty($subtask['description']) ? '' : 'open' ?>>
    <summary class="accordion-title"><?= t('Description') ?></summary>
    <div class="accordion-content">
        <article class="markdown">
            <?= $this->text->markdown($subtask['description'], isset($is_public) && $is_public) ?>
        </article>
    </div>
</details>
