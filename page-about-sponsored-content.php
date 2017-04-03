<?php
	/*
	 * Template Name: Traffic Page
	 */
 ?>

<?php get_header(); ?>
<?php get_template_part( 'parts/homepage/navigation' ); ?>
<div id="dfp-top-placement" class="dfp">
	<?php get_template_part( 'parts/dfp/homepage/dfp-sbb' ); ?>
</div>
<section id="terms-of-use">
	<div class="row">
		<div class="traffic-wrapper">
			<div class="row">
				<div class="large-12 columns">
					<div class="large-8 columns traffic-border">
						<h2><?php the_title(); ?></h2>
							<p>&nbsp;</p>
							<p>The Sun-Times follows these guidelines for custom media in order to ensure full disclosure and transparency.<br>
								We promise to:&nbsp;</p>
							<ul>
								<li>Clearly label sponsored content.</li>
								<li>Adhere to journalism’s core values of honesty, integrity, accountability, and responsibility.</li>
								<li>Credit sources of content or ideas.</li>
								<li>Ensure that the reader understands the source, sponsor, and intent of the content.</li>
								<li>Use real names with all work.</li>
								<li>Disclose all potential conflicts of interest, both to the client before accepting the assignment and to the reader in the final work.</li>
								<li>Pursue all avenues of inquiry to report and write stories with fairness and honesty.</li>
								<li>Use professional writers and give writers credit for their work.</li>
								<li>Employ distinct design/labeling so readers don't confuse custom content with editorial content.</li>
								<li>Ensure that websites/online channels will be updated in a responsible and timely manner.</li>
								<li>Create social media signatures that are clearly labeled as sponsored.</li>
								<li>Reserve the right to approve content to guide against conflicts of interest or potentially harmful alliances.</li>
							</ul>
							<p>We also promise that no member of the editorial staff may be involved in the research, writing, or production of custom publishing content. This policy applies equally to custom publishing content in print, in digital, research and events.</p>
							<p>
								Adapted from: &nbsp;Society of Professional Journalists + Contently.com’s Code of Ethics for Journalism and Content Marketing:</p>
							<p>Examples:<br>
								&nbsp;<br><strong>Advertorial</strong>:<br>
								Content that is submitted by an advertiser. Can be either written by advertiser or written (or rewritten) by custom media division. &nbsp;Generally promotes specific advertiser brand and topics are dictated by advertiser.<br><em>How it should be handled:</em><br><em>Print</em>: Different typefaces. Should be clearly marked “sponsored” or “Produced by…” at top of the page/copy block. If part of page, should be separated from editorial by double rules.<br><em>Online</em>: Clearly marked “sponsored” both on front of site and on top of story, or in separate section.</p>
							<p><strong>What is Custom Publishing?&nbsp;</strong><br>
								This is when a brand pays a publisher to have its name and/or message associated with a particular story. Content typically takes the form of a brief intro paragraph informing readers that the following article is sponsored by an advertiser. You’ll see phrases like “brought to you by,” “presented by,” or “sponsored by.”&nbsp;</p>
							<blockquote><p><em>This is not content produced by the brand. The marketer is given a broad topic area that it can choose to associate its brand with. The marketer does not get a say in what will be produced. (<a href="http://digiday.com/publishers/time-to-define-native-advertising/" target="_blank">Digiday</a>)</em></p>
							</blockquote>
							<p><em>*Can be viewed differently from brand content which, in some circles, is referred to as the content produced by brands and published on their own plaforms, i.e. RedBull</em><br>
								&nbsp;<br><strong>What is Custom Publishing Not?&nbsp;</strong><br>
								Content marketing differs from advertising, advertising-based story-telling and other promotional vehicles in one specific way: the intent of this mode of communication is to provide useful, educational, or entertaining information on its own merit. <strong><u>Content marketing is a pull strategy, unlike advertising, which is push</u></strong>. This marketing technique intends to “pull” the consumer toward the brand and create a user experience which will ultimately increase brand awareness and preference.</p>
						</div>

					<div class="large-4 columns traffic-cube">
						<?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-1' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="section-dfp-bottom-cubes">
	<div class="large-4 columns">
	  <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-2' ); ?>
	</div>
	<div class="large-4 columns">
	  <?php get_template_part( 'parts/dfp/homepage/ndn-video' ); ?>
	</div>
	<div class="large-4 columns">
	  <?php get_template_part( 'parts/dfp/homepage/dfp-rr-cube-3' ); ?>
	</div>
</section>
  <?php get_template_part( 'parts/dfp/homepage/dfp-homepage-mobile-wire-cube-2' ); ?>
  <?php get_template_part( 'parts/dfp/homepage/dfp-btf-leaderboard' ); ?>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer();
