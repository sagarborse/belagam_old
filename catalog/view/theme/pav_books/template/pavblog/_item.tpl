<div class="blog-item">
	<?php if( $config->get('cat_show_title') ) { ?>
	
	<div class="blog-header clearfix">
		<?php if( $config->get('cat_show_created') ) { ?>
		<span class="created bg-color">
			<span class="day"><?php echo date("d",strtotime($blog['created']));?></span>
			<span class="month"><?php echo date("M",strtotime($blog['created']));?></span> /
			<span class="month"><?php echo date("Y",strtotime($blog['created']));?></span>
		</span>
		<?php } ?>
		<h4 class="blog-title normal">	
			<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a>
		</h4>
		<?php } ?>
	</div>
	
	<div class="blog-meta">
		<?php if( $config->get('cat_show_author') ) { ?>
		<span class="author color">
			<span><?php echo $this->language->get("text_write_by");?></span> 
			<?php echo $blog['author'];?>
		</span>
		<?php } ?>
		<?php if( $config->get('cat_show_category') ) { ?>
		<span class="publishin">
			<span><?php echo $this->language->get("text_published_in");?></span>
			<a href="<?php echo $blog['category_link'];?>" title="<?php echo $blog['category_title'];?>"><?php echo $blog['category_title'];?></a>
		</span>
		<?php } ?>
		
		<?php if( $config->get('cat_show_hits') ) { ?>
		<span class="hits">
			<span><?php echo $this->language->get("text_hits");?></span> 
			<?php echo $blog['hits'];?>
		</span>
		<?php } ?>
		<?php if( $config->get('cat_show_comment_counter') ) { ?>
		<span class="comment_count">
			<span><?php echo $this->language->get("text_comment_count");?></span> 
			<?php echo $blog['comment_count'];?>
		</span>
		<?php } ?>
	</div>
	
	<div class="blog-body">
		<div class="row-fluid">
			<?php if( $blog['thumb'] && $config->get('cat_show_image') )  { ?>
			<div class="span4">
				<div class="image blog-image">
					<img src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" alt="" />
				</div>
			</div>	
			<?php } ?>				
					
			<div class="span8">
				<?php if( $config->get('cat_show_description') ) {?>
				<div class="description">
					<?php echo $blog['description'];?>
				</div>
				<?php } ?>
				<?php if( $config->get('cat_show_readmore') ) { ?>
				<div class="view-more">
					<a href="<?php echo $blog['link'];?>" class="readmore button"><?php echo $this->language->get('text_readmore');?></a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>	
</div>