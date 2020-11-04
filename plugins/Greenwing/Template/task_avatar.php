<?php if (! empty($task['owner_id'])): ?>
    <?= $this->myAvatarHelper->tiny(
        $task['owner_id'],
        $task['assignee_username'],
        $task['assignee_name'],
        $task['assignee_email'],
        $task['assignee_avatar_path'],
        'avatar-inline') 
    ?>
<?php endif ?>
