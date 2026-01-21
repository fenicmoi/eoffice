<?php
/**
 * Dynamic Menu Renderer for eOffice
 * Renders the menu based on centralized configuration and user level.
 */

if (!isset($_SESSION['ses_u_id'])) {
    header("location:../index.php");
    exit;
}

require_once 'menu_config.php';

$level_id = $_SESSION['ses_level_id'];
// $dep_id should be available from index_admin.php or where this is included
// $num_row variable for badges might need to be handled if it's not in config

$menus = getMenuConfig($level_id, $dep_id);
?>

<div class="panel panel-<?php echo ($level_id == 1) ? 'danger' : (($level_id == 2) ? 'success' : 'primary'); ?>">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a href="index_admin.php"><i class="fas fa-list" aria-hidden="true"></i> เมนูหลัก
                <?php if ($level_id == 5)
                    echo "(m5)"; ?>
            </a>
        </h4>
    </div>
</div>

<div class="panel-group" id="accordion">
    <?php foreach ($menus as $category): ?>
        <?php
        // Skip category if not allowed or condition not met
        if (!in_array($level_id, $category['allowed_levels']))
            continue;
        if (isset($category['condition']) && !$category['condition'])
            continue;

        // Filter items for this level
        $allowed_items = array_filter($category['items'], function ($item) use ($level_id) {
            return in_array($level_id, $item['allowed_levels']);
        });

        if (empty($allowed_items))
            continue;
        ?>

        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $category['id']; ?>">
                        <i class="<?php echo $category['icon']; ?>" aria-hidden="true"></i>
                        <?php echo $category['title']; ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo $category['id']; ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php foreach ($allowed_items as $item): ?>
                        <?php if (isset($item['divider']) && $item['divider']): ?>
                            <hr>
                        <?php elseif (isset($item['html'])): ?>
                            <?php echo $item['html']; ?>
                        <?php else: ?>
                            <a href="<?php echo $item['url']; ?>"
                                class="btn <?php echo isset($item['btn_class']) ? $item['btn_class'] : 'btn-primary'; ?> btn-block"
                                <?php echo isset($item['target']) ? 'target="' . $item['target'] . '"' : ''; ?>>
                                <?php if (isset($item['icon'])): ?>
                                    <i class="<?php echo $item['icon']; ?> pull-left" aria-hidden="true"></i>
                                <?php endif; ?>
                                <?php echo $item['title']; ?>
                                <?php if (isset($item['badge']) && $item['badge'] > 0): ?>
                                    <span class="badge">
                                        <?php echo $item['badge']; ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <br>
</div>