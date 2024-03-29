<?php
/**
* @package   ZOO Component
* @file      _category.php
* @version   2.0.0 May 2010
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2010 YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div class="category">
<?php if ($category) : ?>

	<?php $link = JRoute::_($this->link_base.'&task=category&category_id='.$category->id); ?>

	<?php if ($this->params->get('template.show_categories_titles')) : ?>
	<h2 class="title">

		<a href="<?php echo $link; ?>" title="<?php echo $category->name; ?>"><?php echo $category->name; ?></a>
		
		<?php if ($this->params->get('template.show_categories_item_count')) : ?>
			<span>(<?php echo $category->countItems(); ?>)</span>
		<?php endif; ?>
		
	</h2>
	<?php endif; ?>

	<?php if ($this->params->get('template.show_categories_descriptions') && $category->getParams()->get('content.teaser_description')) : ?>
	<div class="description"><?php echo $category->getParams()->get('content.teaser_description'); ?></div>
	<?php endif; ?>

	<?php if (($image = $category->getImage('content.teaser_image')) && $this->params->get('template.show_categories_images')) : ?>
	<a class="teaser-image" href="<?php echo $link; ?>" title="<?php echo $category->name; ?>">
		<img src="<?php echo $image['src']; ?>" title="<?php echo $category->name; ?>" alt="<?php echo $category->name; ?>" <?php echo $image['width_height']; ?>/>
	</a>
	<?php endif; ?>

	<?php if ($this->params->get('template.show_sub_categories') && $category->getChildren()): ?>
	<p class="sub-categories">
		<?php
		
			$children = array();
			foreach ($category->getChildren() as $child) {
				if (!$child->countItems()) continue;
				$link = JRoute::_($this->link_base.'&task=category&category_id='.$child->id);
				$item_count = ($this->params->get('template.show_sub_categories_item_count')) ? ' <span>('.$child->countItems().')</span>' : '';
				$children[] = '<a href="'.$link.'" title="'.$child->name.'">'.$child->name.'</a>'.$item_count;
			}
			echo implode(', ', $children);
			
		?>
	</p>
	<?php endif; ?>

	<?php if ($this->params->get('template.show_sub_categories_items')): ?>
	<ul class="sub-items">
		<?php

			foreach ($category->getItems(true, null, $this->item_order) as $item) {
				$link = JRoute::_($this->link_base.'&task=item&item_id='.$item->id);
				echo '<li><a href="'.$link.'" title="'.$item->name.'">'.$item->name.'</a></li>';
			}
			
		?>
	</ul>
	<?php endif; ?>

<?php endif; ?>
</div>