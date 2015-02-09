<?php
/* This file holds all the hooks functions that filter the new navigation*/

/* Removes ability to add a new AMA from the toolbar */
function removeAdminToolbarLink($wp_admin_bar) {
	//Remove toolbar link
	$wp_admin_bar->remove_node('new-ama_post');
}

/* Removes various nav links from custom submenus */
function removeAdminSubmenuLinks(){
    global $submenu;
    unset($submenu['edit.php?post_type=ama_post'][10]);
}

/* Removes the Add New quick button at the top of manage questions screen */
function removeAdminAddNewButton() {
    if (get_current_screen()->post_type === 'ama_questions') {
    	echo '
    	<style type="text/css">
    		.wrap .add-new-h2{
    			display:none !important;
    		}
   		</style>';
    }
}

/* Add an FAQ page */
function FAQPage() {
    add_submenu_page( 'edit.php?post_type=ama_post', 'FAQ', 'FAQ', 'manage_options', 'ama-faq', 'FAQContent' );
}

function FAQContent() {
        echo '
            <div id="faq_wrap">
                <h1>
                    Ask Me Anything Plugin FAQ
                </h1>
                <hr>

                <p><strong>Q:</strong>
                    <em>
                        "Why do I see two modal windows overlapping on a page?"
                    </em>
                </p>
                <p>
                    <strong>A:</strong> This will happen if you include the same shortcode more than one time on a page. As an example, if you include a modal form in the body content of a post, and also include the same modal in the sidebar as a widget, you will get an overlap.
                </p>
                <p>
                    Just ensure that each form included on a page is unique to that page.
                </p>

                <hr>

                <p><strong>Q:</strong>
                    <em>
                        "When I go to manage styles, the form is not that wide. Is that how it will look on my site?"
                    </em>
                </p>
                <p>
                    <strong>A:</strong> No. The form you\'re presented with is just to approximate what your styled form will look like in real time. It won\'t be as narrow, and the input fields will match what you have configured on the real form you\'re applying the style to.
                </p>
                <hr>

                <p><strong>Q:</strong>
                    <em>
                        "Why are the question posts set as drafts when they are submitted"
                    </em>
                </p>
                <p>
                    <strong>A:</strong> By design, all questions submitted are draft by default. As long as they are in a draft state, they won\'t appear in the disussion list. You have to answer the question and then publish it for it to appear in the list.
                </p>
                <hr>

                <p><strong>Q:</strong>
                    <em>
                        "How can I style the list discussion?"
                    </em>
                </p>
                <p>
                    <strong>A:</strong> Styling the list discussion at this point is a manual process. You will have to override the CSS classes. It will be configurable in WordPress in a future release.
                </p>
                <hr>

                <p><strong>Q:</strong>
                    <em>
                        "Can I make suggestions for new features?"
                    </em>
                </p>


                <p>
                    <strong>A:</strong> Of course! You should feel free to make any suggestions that you feel would be an improvement. If others are asking for it as well, it will likely be implemented in future releases.
                </p>
            </div>';
}
?>