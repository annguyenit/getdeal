<?php
set_time_limit(0);
global  $wpdb,$one_time_insert;
//require_once (TEMPLATEPATH . '/delete_data.php');
$dummy_image_path = get_template_directory_uri().'/images/dummy/';
				$dirinfo = wp_upload_dir();
				$path = $dirinfo['path'];
				$url = $dirinfo['url'];
				$destination_path = $path."/";
				$destination_url = $url."/";


//====================================================================================//
/////////////// TERMS START ///////////////
//=============================CUSTOM TAXONOMY=======================================================//
$category_array = array('Fun','Hotels','Restaurants','Tours','Blog','Templates','Coupons','Vouchers');
insert_taxonomy_category($category_array);
function insert_taxonomy_category($category_array)
{
	global $wpdb;
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
					$last_catid = wp_insert_term( $catname, 'category' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'category');
					}
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'category');
			}
		}
	}
	
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'category', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

/////////////// TERMS END ///////////////
$post_info = array();
//////////// Arts - Entertainment /////////////

////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "img1.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Post with Different Headings',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Post with Different Headings',
					"post_content" =>	'This post includes different headings. And many more useful worth seeing content. 
					<strong>Underline text:</strong>
<span style="text-decoration: underline;">Lorem ipsum dolor site amet</span>

&lt;u&gt; Lorem ipsum dolor site amet &lt;/u&gt;

<strong>Italic text:</strong>
<em>Lorem ipsum dolor site amet</em>

&lt;i&gt; Lorem ipsum dolor site amet &lt;/i&gt;

<strong>Strong text:</strong>
<strong>Lorem ipsum dolor site amet</strong>

&lt;strong&gt; Lorem ipsum dolor site amet &lt;/strong&gt;
<h2>&lt;h2&gt;H2 Header: Lorem ipsum dolor sit amet &lt;/h2&gt;</h2>
<h3>&lt;h3&gt;H3 Header: Lorem ipsum dolor sit amet &lt;/h3&gt;</h3>
<h4>&lt;h4&gt;H4 Header: Lorem ipsum dolor sit amet &lt;/h4&gt;</h4>
<h5>&lt;h5&gt;H5 Header: Lorem ipsum dolor sit amet &lt;/h5&gt;</h5>
<h6>&lt;h6&gt;H6 Header: Lorem ipsum dolor sit amet &lt;/h6&gt;</h6>

<strong>List Style:</strong>
<ul>
	<li>Parent
<ul>
	<li>Child</li>
	<li>Child</li>
</ul>
</li>
	<li>Parent</li>
	<li>Parent</li>
</ul>
<pre>&lt;ul&gt;
    &lt;li&gt;Parent
    &lt;ul&gt;
         &lt;li&gt;Child&lt;/li&gt;
         &lt;li&gt;Child&lt;/li&gt;
    &lt;/ul&gt;
    &lt;/li&gt;
    &lt;li&gt;Parent&lt;/li&gt;
    &lt;li&gt;Parent&lt;/li&gt;
&lt;/ul&gt;
</pre>
<strong>Bulleted  List Style:</strong>
<pre>&lt;ol&gt;
    &lt;li&gt;Parent
    &lt;ol&gt;
        &lt;li&gt;Child&lt;/li&gt;
        &lt;li&gt;Child&lt;/li&gt;
    &lt;/ol&gt;
    &lt;/li&gt;
    &lt;li&gt;Parent&lt;/li&gt;
    &lt;li&gt;Parent&lt;/li&gt;
    &lt;li&gt;Parent&lt;/li&gt;
&lt;/ol&gt;
</pre>
<ol>
	<li>Parent
<ol>
	<li>Child</li>
	<li>Child</li>
</ol>
</li>
	<li>Parent</li>
	<li>Parent</li>
	<li>Parent</li>
</ol>
<strong>Address Tag:</strong>

<address> John Smith
12 Westpremium Avenue
Glasgow, G1 1AB
</address>
<pre>&lt;address&gt;
    John Smith
    12 Westpremium Avenue
    Glasgow, G1 1AB
&lt;/address&gt;</pre>
<strong>Strikethrough text:</strong>
&lt;s&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. &lt;/s&gt;

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation .

However, very few stories can truly stand up against the pure terror and the subtle anxiety and dread caused by Bram Stokers infamous novel, "Dracula." The novel is a hallmark of the Gothic horror era, presenting a villain of potentially epic scope in the guise of a remarkable gentleman and nobleman. It deviated from other vampire stories of the time in that the vampire, Dracula, was not monstrous in appearance. He looked every inch a master and nobleman, establishing the "lord of the night" archetype that would be a stock image of vampire characters in literature for centuries to come. It also had all the elements necessary to both frighten readers and keep them coming back for more, marking it as the most enduring horror novel in history.',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "img2.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Testing Different Elements',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Testing Different Elements',
					"post_content" =>	'<strong>What is lorem ipsum?</strong>
Lorem ipsum is simply dummy text of the printing and typesetting  industry. It has been the industry standard dummy text ever since the  1500s. It has been popularised recently with desktop publishing  software and in the 1960s with the release of Letraset sheets containing lorem ipsum passages.

<strong>Blockquote</strong>
<blockquote>Solum reformidans in sed, no regione voluptatum accommodare nam. <strong>See how a blockquote will look like</strong>.</blockquote>

<strong>I am bold text. </strong>

<em>I am italic text. </em>

<strong><em>I am bold and italic text. </em></strong>

<del>Someone striked me out. </del><strong><em>
</em></strong>

Solum reformidans in sed, no regione voluptatum accommodare nam

Do you want to know how unordered list will look like ? Take a look at the preview.
<ul>
	<li>One</li>
	<li>Two</li>
	<li>Three</li>
	<li>Four</li>
	<li>Five</li>
	<li>Six</li>
</ul>
Do you want to know how ordered list will look like ? 
<ol>
	<li>One</li>
	<li>Two</li>
	<li>Three</li>
	<li>Four</li>
	<li>Five</li>
	<li>Six</li>
</ol>
Solum reformidans in sed, no regione voluptatum accommodare nam. <a href="#">Here is how a link would look like</a>, dicant mediocrem efficiendi in mea. Tantas iisque  eleifend te vix, per ex mucius vocent accusamus. Duo quot movet soluta  eu, odio vivendo cu eum, id cum nobis fabulas efficiantur.

<strong>Roots of lorem ipsum?</strong>
Lorem ipsum is not simply random text. It is actually over 2000 years old and it has roots in a piece of classical Latin literature from 45 BC. Lorem ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum (The Extremes of Good and Evil) written in 45 BC by  Marcus Tullius Cicero. The first line of lorem ipsum, Lorem ipsum  dolor sit amet.., can be read out of a line from section 1.10.32.  This  book was very popular during the Renaissance and it is a treatise  on  the theory of ethics.

<h3>Feature</h3>
<ol>
	<li>Eagle tattoos are unique in themselves and it can be also done in many different creative ways and just about anywhere on the body but still the most common area for this type of tattoo is the upper arm, followed by the shoulders, and the upper and lower back areas.</li>
	<li>Eagle tattoos whether it is with spread wings or roosting position are really eye-catching.</li>
	<li>The most important feature of eagle tattoo is its feather. </li>
	<li>So if the tattoo is done on a large area with spread wings where every details of the wing are clearly visible provides the eagle tattoo with a realistic appearance. </li>
	<li>The back is a great location for eagle tattoo with their wings fully spread as if in flight. </li>
	<li>You can also ink your back with another popular swooping pose of an eagle. </li>
	<li>This swooping poses of the eagle targeting its prey with sharp talons is really mind blowing, and of course the internet and many tattoo shops are full of images of the majestic eagle in varying poses.</li>
</ol> 

Small eagle tattoos featuring only the head of the bird can be inked on the leg or armbands, or can be incorporated into another design. There are many tattoo shops and websites that will provide you with varying poses of eagle.',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "img3.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Collection of all Content Boxes and Dropcaps',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Collection of all Content Boxes and Dropcaps',
					"post_content" =>	'<h3> Dropcaps Content</h3>
[Dropcaps] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. [/Dropcaps]

[Dropcaps] Dropcaps can be so useful sometimes. Sorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula.  [/Dropcaps]

<h3>Content boxes</h3>

We, the boxes can be used to highlight special parts in the post. We can be used anywhere, just use the particular shortcode and we will be there.

[Normal_Box]<h3>Normal Box</h3>
<p>This is how a normal content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.</p>
[/Normal_Box]

[Warning_Box] <h3>Warring Box</h3>
<p>This is how a warning content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.</p>
[/Warning_Box]

[Download_Box]<h3>Download Box</h3>
<p>This is how a download content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.</p>
[/Download_Box]

[About_Box]<h3>About Box</h3>
<p>This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.</p>
[/About_Box]


[Info_Box]<h3>Info Box</h3>
<p>This is how a info content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.</p>
[/Info_Box]

[Alert_Box]<h3>Alert Box</h3>
<p>This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.</p>
[/Alert_Box]

Chinese painting is called shui-mo-hua. Shui-mo is the combination of shui (water) and mo. There are two styles of Chinese painting. They are gong-bi or detailed style, and xie-yi or freehand style. The second is the most common, not only since the objects are depicted with just a few strokes, but likewise because shapes and sprites are drawn by uncomplicated curves and natural ink. Many ancient poets and students used xie-yi paintings to give tongue to their religious anguish.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "img4.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'The Best Deals on the Internet',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'The Best Deals on the Internet',

					"post_content" =>	'Did you know that we offer the best deals on the planet. Yes, and we mean it. Take a look at all our deals online and save money. Why pay more, when you can pay less and get work done.
Famous artists paintings have earned world wide recognition in different periods of times. Famous painters paintings truly an asset for fine arts. There have been a great number of famous painters in different parts of the world in different periods of times. These include Marc Chagall, Salvador Dali, Leonardo Da Vinci, Paul Klee, Henri Matisse,Claude Monet, Pablo Picasso,Pierre Auguste Renoir,Henri Rousseau,Henri de Toulouse-Lautrec,Vincent Van Gogh,Andy Warhol.

<h3>Ordered list</h3>
<ol>
	<li>Famous abstract paintings present the fine art at the highest level. </li>
	<li>Famous abstract artists have been gratly greatly appreciated for their famous abstract oil paintings. </li>
	<li>Picasso is one of the most famous abstract painter. Picasso became very famous because he work in multiple styles.</li>
	<li>Famous paintings of Picasso are Guernica ,Three Musicians,The Three Dancers and Self Portrait: Yo Picasso.</li>
	<li>Picasso famous paintings have earned him worldwide recognition.</li>
</ol> 

Many famous flower paintings have been created by the outstanding flower painters. Famous Floral Oil Paintings are in wide range of styles. Famous floral fine art paintings are exquisite. Famous landscape paintings are the master pieces of fine art. Famous Landscape painters have created a great number of famous landscape paintings. Famous Landscape art has greatly been admired in all the periods of times. Famous contemporary landscape painters have successfully attained the mastery in the landscape art.

Still life fruit paintings and fruit bowl paintings make the famous fruit paintings. The highly skilled artists have also created the most famous paintings of rotting fruit. The modern famous artists are successful creating the masterpieces of still fruit oil paintings and oil pastel fruit paintings.

Famous still Life art depicts drinking glasses, foodstuffs, pipes, books and so on. Famous Still life paintings are indeed the master pieces of fine art. Woman portrait paintings make the famous portrait paintings. There are also famous portrait paintings of men. Famous portrait paintings of Oscar dela hova have been greatly appreciated. Japanese women portrait paintings are very popular in Japanese culture. In addition to women portrait paintings and portrait paintings of men, there are many famous pet portrait paintings and famous portrait paintings of houses and famous paintings of sports cars.

In addition to above styles, there are many famous paintings of other subjects. These include famous war paintings, famous paintings of jesus, famous figure paintings, religious famous paintings, famous paintings romantic, famous battle paintings, famous military paintings, famous sunset paintings, famous paintings of women, famous paintings of love, famous water paintings, famous acrylic paintings, famous paintings of buildings, famous dance paintings, famous dragon paintings, famous black paintings, famous paintings in the fall, famous paintings of cats, famous paintings of children, famous paintings of friends, famous paintings of christinaity, famous paintings of jesus and famous paintings of humanity. There are also famous native American paintings and famous Spanish paintings.

',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "img5.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Behind the Deals',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Behind the Deals',
					"post_content" =>	'Want to take a look at behind the scenes at what is happening ? You are invited. Yes, you would be surprised to see what is happening and how things work here at Daily Deal. Oh and this is the best Daily deal theme out yet.

<h3>H3 Heading</h3>
The first documented case of art theft was in 1473, when two panels of altarpiece of the Last Judgment by the Dutch painter Hans Memling were stolen. While the triptych was being transported by ship from the Netherlands to Florence, the ship was attacked by pirates who took it to the Gdansk cathedral in Poland. Nowadays, the piece is shown at the National Museum in Gdansk where it was recently moved from the Basilica of the Assumption. The Most Famous Theft:
The most famous story of art theft involves one of the most famous paintings in the world and one of the most famous artists in history as a suspect. In the night of August 21, 1911, the Mona Lisa was stolen out of the Louver. Soon after, Pablo Picasso was arrested and questioned by the police, but was released quickly.


While Yves Chaudron, the art faker, was busy creating copies for the famous masterpiece, Mona Lisa was still hidden at Peruggias apartment. After two years in which Peruggia did not hear from Chaudron, he tried to make the best out of his stolen good. Eventually, Peruggia was caught by the police while trying to sell the painting to an art dealer from Florence, Italy. The Mona Lisa was returned to the Louver in 1913.

<h4>H4 Heading</h4>
The biggest art theft in United States took place at the Isabella Stewart Gardner Museum. On the night of March 18, 1990, a group of thieves wearing police uniforms broke into the museum and took thirteen paintings whose collective value was estimated at around 300 million dollars. The thieves took two paintings and one print by Rembrandt, and works of Vermeer, Manet, Degas, Govaert Flinck, as well as a French and a Chinese artifact.

As of yet, none of the paintings have been found and the case is still unsolved. According to recent rumors, the FBI are investigating the possibility that the Boston Mob along with French art dealers are connected to the crime.

Ten years later, The Scream was stolen again from the Munch Museum. This time, the robbers used a gun and took another of Munchs painting with them. While Museum officials waiting for the thieves to request ransom money, rumors claimed that both paintings were burned to conceal evidence. Eventually, the Norwegian police discovered the two paintings on August 31, 2006 but the facts on how they were recovered are not known yet.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "img6.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Behind the Deals Lunch Hour',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Behind the Deals Lunch Hour',
					"post_content" =>	'Daily Deal employees start out as regular people and, like regular people, they must eat at least once a day. Taking a standard lunch hour is encouraged, and our staff of overachievers spends this hour carefully. Really carefully.
					Selecting art for your home can be an exciting adventure and a source of enjoyment for years to come. Keys to success are figuring out what kind of art you like, how it will fit in with the rest of your interior design plans, and how to exhibit the art to the best effect in your home.
					
<h3>H3 Heading Text Here</h3>
There are many opportunities to browse art within your community at local exhibitions, art fairs and galleries. Even small towns usually have a not-for-profit gallery space, or cafes and restaurant that exhibit local artists. In larger cities, galleries often get together for monthly or periodic "gallery nights" where all the galleries hold open house receptions on the same evening. Its a great way to see a lot of art in a short time.

Today the internet provides the largest variety and depth of fine art available worldwide. You can visit museum websites and see master works from ages past, check out online galleries for group shows, and visit hundreds of individual artists websites. One advantage of using the internet is that you can search for the specific kind of art you are interested in, whether its photography, impressionism, bronze sculpture, or abstract painting. And when you find one art site, youll usually find links to many, many more.

<h4>H4 Heading Text</h4>
<h5>H5 Heading Text</h5>
If you feel strongly about a particular work of art, you should buy the art you love and then find a place to put it. But you may find that when you get the art home and place it on a wall or pedestal, it doesnt work with its surroundings. By not "working," I mean the art looks out of place in the room. Placing art in the wrong surroundings takes away from its beauty and impact.

What should you do if you bring a painting home and it clashes with its environment? First, hang the painting in various places in your home, trying it out on different walls. It may look great in a place you hadnt planned on hanging it. If you cant find a place where the art looks its best, you may need to make some changes in the room, such as moving furniture or taking down patterned wallpaper and repainting in a neutral color. The changes will be worth making in order to enjoy the art you love.

Sometimes the right lighting is the key to showing art at its best. You may find that placing a picture light above a painting or directing track lighting on it is all the art needs to exhibit its brilliance. If you place a work of art in direct sunlight, however, be sure it wont be affected by the ultraviolet light. Pigments such as watercolor, pencil and pastel are especially prone to fading. Be sure to frame delicate art under UV protected glass or acrylic.

Another possibility for dealing with color is to choose art with muted colors, black-and-white art, or art that is framed in a way that mutes its color impact in the room. A wide light-colored mat and neutral frame create a protected environment for the art within.

Style is another consideration when selecting art to fit a room. If your house is filled with antiques, for example, youll want to use antique-style frames on the paintings you hang there. If you have contemporary furniture in large rooms with high ceilings, youll want to hang large contemporary paintings.

<h3>How to create an art-friendly room.</h3>
Think about it. When you walk into a gallery or museum, what do they all have in common? White walls and lots of light. If a wall is wall-papered or painted a color other than white, it limits the choices for hanging art that will look good on it. If a room is dark, the art will not show to its best advantage.

If you want to make art the center of attraction, play down the other elements of the room like window coverings, carpeting, wall coverings, and even furniture. A room crowded with other colors, textures and objects will take the spotlight away from the art. Follow the principle that less is more. Keep it spare and let the art star. Then relax and enjoy it.

Selecting and displaying art is an art in itself. Experiment to learn what pleases you and what doesnt. Youll be well-rewarded for the time you invest by finding more satisfaction both in the art and in your home.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "img7.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Customer Service is our First Priority',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Customer Service is our First Priority',
					"post_content" =>	'Like every other company, we at Daily Deal, take customer service seriously. And this is our first priority. We value our customers, and we know that customer is the king of the market. 
					
There are many museums of modern paintings all over the world. The modern paintings of the modern artists are exhibited in these museums. These museums of modern art have been successful in flourishing the contemporary art. Modern artists exhibit their modern paintings creations in the museum of contemporary art. Museum of modern art New york, Contemporary art museum Houston, museum of modern art paris, art museum of Fort worth are the famous museums of contemporary art. Contemporary art work can be seen in these modern art museums.These museums exhibit the popular contemporary paintings of the famous modern artists.

<h3>H3 Heading looks like this</h3>
<ol>
	<li>There are great number of painters of modern life. </li>
	<li>They have created the modern abstract art on modern themes. </li>
	<li>Modern artists paint colours in an artistic way. </li>
	<li>Their contemporary oil paintings are pure form of fine arts. </li>
	<li>History of modern art is full of great contemporary paintings from famous modern artists. </li>
	<li>19th century paintings and 20th century paintings are worth seeing. </li>
	<li>Modern art movements have been in progress in recent times. </li>
	<li>There are many contemporary art centers. </li>
	<li>Contemporary art center Cincinnati and Contemporary art center of Virginia are the famous modern art center. </li>
	<li>St.Louis contemporary art has been very much appreciated. Contemporary Christian artists</li>
<ol>

Modern art is also available for sale. Modern and contemporary art can be purchased from the modern art gallery. These contemporary art galleries offer the Original modern paintings of the famous contemporary artist. The reproductions of the famous contemporary paintings can also be purchased from these modern art galleries. These galleries also offer cheap price modern oil paintings.

Good News for lovers of modern art ! You can get Contemporary and Modern Oil Paintings of your own choice just by selecting the Model number of the Landscape Oil Painting or by sending the Photo of your required image. Our highly skilled modern artists can reproduce the contemporary paintings as per your given photo. Just click the Link of Contemporary paintings on our website (www.paintingsgifts4u.com) . For more details, Please contact us at : info@paintingsgifts4u.com.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "img8.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Meet a Deal Employee',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Meet a Deal Employee',
					"post_content" =>	'There should be some fun and not just official posts. Hence, meet the Deal employee. His name is Roy. James Roy. Oh and you thought the name is James Bond. Sorry to disappoint. 	
His art remained true and sincere, he declined to make the smallest concession to what silly sitters called their taste, but he did not really know what to do with the money and commissions that flowed in upon him so freely. The best use he made of changing circumstances was to become engaged to Saskia van Uylenborch, the cousin of his great friend Hendrick van Uylenborch, the art dealer of Amsterdam. Saskia, who was destined to live for centuries, through the genius of her husband, seems to have been born in 1612, and to have become engaged to Rembrandt Van Ryn when she was twenty. The engagement followed very closely upon the patronage of Rembrandt Van Ryn by Prince Frederic Henry, the Stadtholder, who instructed the artist to paint three pictures.

<ol>
	<li>Saskia is enshrined in many pictures. </li>
	<li>She is seen first as a young girl, then as a woman. </li>
	<li>As a bride, in the picture now at Dresden, she sits upon her husbands knee, while he raises a big glass with his outstretched arm. </li>
	<li>Her expression here is rather shy, as if she deprecated the situation and realised that it might be misconstrued. </li>
	<li>This picture gave offence to Rembrandt Van Ryns critics, but some portraits of Saskia remained to be painted. </li>
	<li>She would seem to have aged rapidly, for after marriage her days were not long in the land. </li>
	<li>She was only thirty when she died, and looked much older.</li>
</ol>

In 1638 we find Rembrandt Van Ryn taking an action against one Albert van Loo, who had dared to call Saskia extravagant. It was, of course, still more extravagant of Rembrandt Van Ryn to waste his money on lawyers on account of a case he could not hope to win, but this thought does not seem to have troubled him. He did not reflect that it would set the gossips talking more cruelly than ever. Still full of enthusiasm for life and art, he was equally full of affection for Saskia, whose hope of raising children seemed doomed to disappointment, for in addition to losing the little Rombertus, two daughters, each named Cornelia, had died soon after birth. In 1640 Rembrandt Van Ryns mother died. Her picture remains on record with that of her husband, painted ten years before, and even the biographers of the artist do not suggest that Rembrandt Van Ryn was anything but a good son. A year later the well-beloved Saskia gave birth to the one child who survived the early years, the boy Titus. Then her health failed, and in 1642 she died, after eight years of married life that would seem to have been happy. In this year Rembrandt Van Ryn painted the famous "Night Watch," a picture representing the company of Francis Banning Cocq, and incidentally a day scene in spite of its popular name. The work succeeded in arousing a storm of indignation, for every sitter wanted to have equal prominence in the canvas.

Between 1642, when Saskia died, and 1649, it is not easy to follow the progress of his life; we can only state with certainty that his difficulties increased almost as quickly as his work ripened. His connection with Hendrickje Stoffels would seem to have started about 1649, and this woman with whom he lived until her death some thirteen years later, has been abused by many biographers because she was the painters mistress.

He has left to the world some 500 or 600 pictures that are admitted to be genuine, together with the etchings and drawings to which reference has been made. He is to be seen in many galleries in the Old World and the New, for he painted his own portrait more than a score of times. So Rembrandt Van Ryn has been raised in our days to the pinnacle of fame which is his by right; the festival of his tercentenary was acknowledged by the whole civilised world as the natural utterance of joy and pride of our small country in being able to count among its children the great Rembrandt Van Ryn.
					
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "img9.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Live Stream the Webby Awards.',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Live Stream the Webby Awards',
					"post_content" =>	'Thanks to your support, next Monday Deals heads to the Webby Awards. In 2006 the Turner Prize gained its first ever female winner. Head to Deals Facebook page and click the Watch Webbys Live tab on the left side. We hope you would love watching it online. 

In no particular order of importance these were sculptress Rebecca Warren who was the fancied hot favourite with many bookies, billboard artist Mark Titchner and finally film maker Phil Collins(No not him of Genesis fame!).

When the judges cast their votes however it was Tomma Abts who came out on top. She won twenty five thousand british pounds and of course the Turner Prize itself. I am sure the money will come in handy however its the exposure that Tomma will get from winning thats the really important thing here.

What does Tomma Abts do? Well she actually paints abstract art; usually in oils or acrylics. Something of a novelty for the Turner Prize some would say! Tomma Abts was originally selected for her solo art exhibitions at Kunsthalle Basel, Switzerland, and Greengrassi, London.

<ol>
	<li>Tomma Abts has been praised by no less than the Tate Gallery who describes her canvases as "intimate" and "compelling" . </li>
	<li>They also comment on Tommas "consistent" and even "rigorous" method of painting. </li>
	<li>In addition the Tate states that Tomma Abts "enriches the language of abstract art" .</li>
	<li>With such praise heaped upon her head its no surprise to me that she won the prize. </li>
	<li>However I actually feel that Tommas abstract artwork isnt "knock out" but it definitely is OK.</li>
</ol>

When creating titles for her paintings apparently Tomma simply plucks one from a dictionary of German first names. Titles like Veeke for example were created in this way. In my view this is surely only slightly more interesting than numbering each picture!

All in all I think that Tomma Abts creates abstract art that is pretty accessible to the public at large. This is something that perhaps could not be said about the artwork of previous Turner Prize winners! I base my opinion of course on Tommas prize winning paintings. I would go further and state that I cannot conceive of a Tomma Abts creation offending anyone even slightly.

In the end its just my personal opinion but I do believe that its entirely posible that Tomma Abts will go on to become a household name - within her own lifetime...Of course she could also disappear without trace from the media - and our minds in the blink of an eye, for precisely the same reasons.				
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///  
//====================================================================================//
////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "img10.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'And the Contest Winner is',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'And the Contest Winner is',
					"post_content" =>	'Want to know who is the contest winner. Then you have come to the right place. And finally we are declaring our winner. And the winner is Jessie. Many congrats to Jessie for winning this contest.
					Calligraphy is a visible expression of the highest art of all for the muslim. It is the art of the spiritual world. Calligraphy literally means writing beautifully and ornamentally. Islamic calligraphy is the art of writing, and by extension, of bookmaking. This art has most often employed the Arabic script, throughout many languages. Since Arabic calligraphy was the primary means for the preservation of the Quran, Calligraphy is especially revered among Islamic arts. The work of the famous muslim calligraphers were collected and greatly appreciated throughout Islamic history. Consideration of figurative art as idolatrous led to calligraphy and abstract figures becoming the main methods of artistic expression in Islamic cultures. Contemporary muslim calligraphers are also producing the Islamic calligraphy of high artistic quality.

<h3>Calligraphic scripts</h3>
<ol>
	<li>The Kufic script is the first of those calligraphic scripts to gain popularit. </li>
	<li>It was angular, made of square and short horizontal strokes, long verticals, and bold, compact circles. </li>
	<li>For three centuries, this script had been mainly used to copy the Quran. </li>
	<li>The cursive Naskh script was more often used for casual writing. </li>
	<li>This script had rounder letters and thin lines. </li>
	<li>It would come to be preferred to Kufic for copying the Quran as techniques for writing in this style were refined. </li>
	<li>Almost all printed material in Arabic is in Naskh. </li>
	<li>The Thuluth would take on the ornamental role formerly associated with the Kufic script in the 13th century. </li>
	<li>Thuluth is usually written in ample curves as it has a strong cursive aspect. </li>
	<li>The Persians took to using Arabic script for their own language, Persian after their conversion to Islam. </li>
	<li>The Taliq and Nastaliq styles were contributed to Arabic calligraphy by the Persians. </li>
	<li>Nastaliq style is extremely cursive, with exaggeratedly long horizontal strokes. </li>
	<li>The Diwani script is a cursive style of Arabic calligraphy. </li>
	<li>It was developed during the reign of the early Ottoman Turks (16th and early 17th centuries). </li>
	<li>This outstanding Diwani script was both decorative and communicative. </li>
	<li>Finally, Riqa is the most commonly used script for everyday use. </li>
	<li>It is simple and easy to write. </li>
	<li>Its movements are small.</li>
	<li>In China, a calligraphic form called Sini has been developed. </li>
	<li>This form has evident influences from Chinese calligraphy. </li>
	<li>Hajji Noor Deen Mi Guangjiang is a famous modern calligrapher in this tradition.</li>
</ol>
 
<h3>H3 Heading</h3>
Pakistan has produced calligraphist of international recognition. Sadeqain is on of these international fame Islamic calligraphist. He was an untraditional and self-made, self-taught painter and calligrapher. He did a lot of work on Quranic calligraphy. Many other contemporary Pakistani calligraphists like Gul Gee have created great contemporary Islamic calligraphy. These days, Islamic calligraphies of Tufail and Uzma Tufail are getting very much popular both in Pakistan and all over the world.

<h3>Islamic Calligrahpy as an Islamic Gift</h3>
The Muslims love to adore their homes, offices and places of their work with the Islamic calligraphy. The Islamic calligraphies especially the verses from the Holy Quran and the verses from the sayings of the Holy Prophet are considered to be very sacred to muslims. Islamic calligraphy indeed make the perfect gift for a muslim for any special occasion. A muslim can send an Islamic gift of Islamic calligraphy to congratulate his relative or friend on his new home or new office or on his birthday or wedding ceremony or on Eid Festival.

It is great news for the muslims living all over the world to get the Islamic paintings and Islamic calligraphy of their own choice. Please visit our website at www.paintingsgifts4u.com and click the section of the Islamic paintings. You can get Islamic Calligraphy of your choice just by selecting the Item number of the Islamic Painting or by sending the Holy verse of your choice. We also supply Islamic paintings and Islamic Calligraphy from Pakistan on wholesale basis at very best prices. We are supplying cheap Islamic paintings and cheap Islamic calligraphies with high quality. 
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{

		$post_title = $post_info[$i]['post_title'];
		$post_exp = $post_info[$i]['post_excerpt'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
		
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_excerpt'] = $post_info_arr['post_excerpt'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
	
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//=============================CUSTOM TAXONOMY=======================================================//
$post_info = array();
insert_taxonomy_category($category_array);
/// Deal 1 ////post start 1//
$image_array[] = "todaydeal.png" ;
$post_meta = array();
$cstartdate = strtotime(date('Y-m-d'));
$date = date('Y-m-d');
$day = explode("-",$date);
$m = $day[1];
$d = $day[2];
$y = $day[0];
$cenddate = strtotime(date('Y-m-d', mktime(0,0,0,$m,$d+10,$y)));
$cenddate;
$expdate = strtotime(date('Y-m-d', mktime(0,0,0,$m,$d-5,$y)));
$post_meta = array(
					"is_expired"	       		=> '0',
					"is_show"	       		=> '1',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '2',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"				=>  $destination_url.'dummy/img11.jpg',
					"our_price"	        		=> '20',
					"current_price"	 			=> '100',
					"coupon_entry"				=> 'coupon_entry_1',
					"thankyou_page_url"			=> 'http://templatic.com',
			);
$post_info[] = array(
					"post_title"	    =>	'Get 5 Professional Themes for just $39; save 82%',
					"post_excerpt"	    =>	'One of the best ways to make a design stand out is by choosing a really stylish font. In fact, a cool font and balanced typography alone can carry an entire design.
		
		Today&rsquo;s deal brings you two unique and exciting news fonts crafted by Giuseppe Salerno. They&rsquo;re super funky and have a unique flare that&rsquo;s sure to grab second looks. Today you can get both the Afrobeat Font and the Wonderwall Font together for only $20 instead of $55. That&rsquo;s 64% off!',
					"post_content"	    =>	'1st deal -- Deal type: Digital Product deal
	
		Title: MP3 deal: 50 Heavy Metal albums for just $15
		Deal ends in: Far future date | $250 -- $15
		Description :
		There&rsquo;s just a few days left of celebration of heavy metal with the 50 $15 Metal albums sale. For only $15 for MP3 format, there are some insanely good must-have metal albums up for sale through the end of Jan 2012, like Metallica‘s …And Justice For All, Judas Priest‘s Screaming For Vengeance, Black Sabbath‘s Heaven And Hell, Quiet Riot‘s Metal Health, and many more, including some really great "Best Of" compilations.
		
		I picked out a few here below, but be sure to check out the main sale page to see all the albums available now for only $15. 
		
		Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"     =>	array('Templates'),
					"post_tags" =>	array('Tags','Sample Tags')					
					);
////post end/// 
/// Deal 2 ////post start 2//
$image_array[] = "img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"					=> $destination_url.'dummy/img2.jpg',
					"our_price"	        		=> '60',
					"current_price"	 			=> '150',
					"coupon_entry"				=> 'coupon_entry_1',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'$35 Authentic Indian Banquet for 2 including a mixed platter entrée, curries & 2 Glasses of wine at The Taj ($85 value)',
					"post_excerpt"	    =>	'Great dancers are like Indian food; they contain a bit of spice and zing and always finish routines by rolling in steaming hot rice mounds. Let the tastebuds do the dancing and avoid rice-related strains with today&rsquo;s delectable deal: $35 for an authentic Indian banquet for two people including shared mixed platter entrée, any four curries, sides, rice, bread and two glasses of wine at The Taj ($85 value).',
					"post_content"	    =>	'Great dancers are like Indian food; they contain a bit of spice and zing and always finish routines by rolling in steaming hot rice mounds. Let the tastebuds do the dancing and avoid rice-related strains with today&rsquo;s delectable deal: $35 for an authentic Indian banquet for two people including shared mixed platter entrée, any four curries, sides, rice, bread and two glasses of wine at The Taj ($85 value).
		
		Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category" =>	array('Coupons','Vouchers'),
					"post_tags" =>	array('food','indian','cuisines'),
					);
////post end/// 
/// Deal 3 ////post start 3//
$image_array[] = "img3.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"				=> $destination_url.'dummy/img4.jpg',
					"our_price"	        		=> '20',
					"current_price"	 			=> '40',
					"coupon_entry"				=> 'coupon_entry_1',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'$29 for One-Year Basic Membership Including Access to Events With Celebrity Guests and Speakers ($150 Value)',
					"post_excerpt"	    =>	'An eclectic mix of distinguished luminaries descends from the starry heights of celebrity to engage with people from across the social spectrum via the Hudson Union Society&rsquo;s robust lineup of speaking events, film premieres, and A-list celebrity mixers.',
					"post_content"	    =>	'An eclectic mix of distinguished luminaries descends from the starry heights of celebrity to engage with people from across the social spectrum via the Hudson Union Society&rsquo;s robust lineup of speaking events, film premieres, and A-list celebrity mixers.
		
		Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Vouchers'),
					"post_tags" =>	array('memberships','royal parties'),
					);
////post end/// 
/// Deal 4 ////post start 4//
$image_array[] = "img5.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '2',
					"coupon_link"	        	=> 'www.test.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"file_name"				=> $destination_url.'dummy/img6.jpg',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '30',
					"current_price"	 			=> '60',
					"coupon_entry"				=> 'coupon_entry_1',
					"_wp_attached_file"         => 'food.pdf',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'50% off on all products listed on BuythisNow.com (more than $150 Value)',
					"post_excerpt"	    =>	'This is a custom affiliate link deal. Very easy to setup. Just select Custom link deal as the deal type. Users will be able to visit the affliate links by clicking the Buy Now button. Very simple, is not it? ',
					"post_content"	    =>	'This is a custom affiliate link deal. Very easy to setup. Just select Custom link deal as the deal type. Users will be able to visit the affliate links by clicking the &lsquo;Buy Now&rsquo; button. Very simple, isn&rsquo;t it? 
		
		Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.	',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category"     =>	array('Coupons'),
					"post_tags" =>	array('affiliate','coupon'),
					);
////post end/// 
/// Deal 5 ////post start 5//
$image_array[] = "img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '2',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '50',
					"file_name"				=> $destination_url.'dummy/img1.jpg',
					"current_price"	 			=> '100',
					"coupon_entry"				=> 'coupon_entry_1',
					"_wp_attached_file"         => 'food.pdf',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Sheridans Unforked Overland Park',
					"post_excerpt"	    =>	'It can be tough to tell cage fed chickens from free-range and even tougher to discern an organic head of lettuce from a genetically engineered head of lettuce with the body of a lion. Save the time you would spend deliberating with todays Groupon to Sheridans Unforked in Overland Park. A plethora of aerodynamic tacos swiftly deliver savory cargo',
					"post_content"	    =>	'It can be tough to tell cage fed chickens from free-range and even tougher to discern an organic head of lettuce from a genetically engineered head of lettuce with the body of a lion. Save the time you would spend deliberating with todays Groupon to Sheridans Unforked in Overland Park. A plethora of aerodynamic tacos swiftly deliver savory cargo, such as the citrus crunch chicken ($3.30), or a muscle building conglomeration of scrambled egg whites, spinach, blistered poblanos, and queso fresco on the Popeye breakfast taco ($4.00).
														
<p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Tours'),
					"post_tags" =>	array('Tags','Sample Tags'),
					);
////post end/// 
/// Deal 6 ////post start 6//
$image_array[] = "img2.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '2',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"				=> $destination_url.'dummy/img2.jpg',
					"our_price"	        		=> '40',
					"current_price"	 			=> '100',
					"coupon_entry"				=> 'coupon_entry_1',
					"_wp_attached_file"         => 'food.pdf',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Riviera Palm Springs Resort and Spa Palm Springs',
					"post_excerpt"	    =>	'As the sun sets on the facade of the Riviera Palm Springs Resort and Spa, the resort radiates a soft, luminous glow, shining jewel like amid the sterling setting of its rustic desert surroundings. Inside, the Rivieras dazzling modern lobby and sleek lounges echo with the sounds of bubbly conversation',
					"post_content"	    =>	'As the sun sets on the facade of the Riviera Palm Springs Resort and Spa, the resort radiates a soft, luminous glow, shining jewel like amid the sterling setting of its rustic desert surroundings. Inside, the Rivieras dazzling modern lobby and sleek lounges echo with the sounds of bubbly conversation, clinking glassware, and softly thumping music. The two mirrored, loveseat strewn lounges, Sidebar and the Starlite Lounge, sustain their vibrant energy late into the night, enticing hotel guests to mingle over light appetizers and signature cocktails as live jazz and soul complement late night DJ sessions, inspiring spontaneous dance parties.
					
					During the daylight hours, travelers take shelter from the desert sun Old California style bungalows, lavishly appointed three floor buildings spread out over the hotels generous 24 acre campus, each housing its own cache of guest rooms.
					
<p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category" =>	array('Hotels'),
					"post_tags" =>	array('Tags','Sample Tags'),
					);
////post end/// 
/// Deal 7 ////post start 7//
$image_array[] = "img4.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '3',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '50',
					"file_name"				=> $destination_url.'dummy/img4.jpg',
					"current_price"	 			=> '125',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Art Source And Design Westbrooke Village Shopping Center',
					"post_excerpt"	    =>	'Until their proper display in museums, the paintings of most Renaissance masters languished for centuries on the magnet flecked fridges of their proud mothers. Preserve your art for future generations and houseguests with todays deal: for $50, you get $125 worth of custom framing or art at Art Source and Design in Shawnee.',
					"post_content"	    =>	'Until their proper display in museums, the paintings of most Renaissance masters languished for centuries on the magnet flecked fridges of their proud mothers. Preserve your art for future generations and houseguests with todays deal: for $50, you get $125 worth of custom framing or art at Art Source and Design in Shawnee.
					
					Shadowboxes for multidimensional collectibles and a vast array of frames and mats for family portraits help to protect the lives of memorable items while allowing interest on sentimental value to grow exponentially. The knowledgeable employees work with the design ideas and budgetary limitations of each customer to help narrow down the selection while lending their own artistic advice. 
														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category" =>	array('Misc'),
					);
////post end/// 
/// Deal 8 ////post start 8//
$image_array[] = "img6.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '3',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '25',
					"file_name"				=> $destination_url.'dummy/img6.jpg',
					"current_price"	 			=> '150',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'OK Magazine Online Deal',
					"post_excerpt"	    =>	'Books, like children, require attention for long periods of time and take up valuable space, whereas magazines can be quickly read and stuffed into cereal boxes when not in use. Take a stand against roomy reading material with today deal: for $25, you get a one year subscription (51 issues) to OK Magazine.',
					"post_content"	    =>	'Books, like children, require attention for long periods of time and take up valuable space, whereas magazines can be quickly read and stuffed into cereal boxes when not in use. Take a stand against roomy reading material with today deal: for $25, you get a one year subscription (51 issues) to OK Magazine.

OK Magazine dishes up the latest celebrity gossip, supplemented by of the moment beauty and style advice, in widely circulated weekly issues. 
					
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,			
					"post_category" =>	array('Misc'),
					);
////post end/// 
/// Deal 9 ////post start 9//
$image_array[] = "img8.jpg" ;
$post_meta = array();
$cstartdate = date('Y m d H:i:s');
$post_meta = array(
					"is_expired"	       		=> '0',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '3',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"					=> $destination_url.'dummy/img8.jpg',
					"our_price"	        		=> '30',
					"current_price"	 			=> '70',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Jalsa Indian Fast Food Columbia Heights',
					"post_excerpt"	    =>	'Many diners at Indian restaurants defend vulnerable plates of curry by slapping away the grasping hands of dining partners with oversized slabs of naan. Defend culinary turfs with todays deal for $10, you get $15 worth of Indian fare at Jalsa Indian Fast Food in Hilltop.
					Jalsa Indian Fast Food transports diners on an aromatic journey through many regions of India with an authentic menu of traditional street fare. Diners collect several snack sized dishes, or chaat, to construct an eclectic meal. ',
					"post_content"	    =>	'Many diners at Indian restaurants defend vulnerable plates of curry by slapping away the grasping hands of dining partners with oversized slabs of naan. Defend culinary turfs with todays deal for $10, you get $15 worth of Indian fare at Jalsa Indian Fast Food in Hilltop.
					Jalsa Indian Fast Food transports diners on an aromatic journey through many regions of India with an authentic menu of traditional street fare. Diners collect several snack sized dishes, or chaat, to construct an eclectic meal. 														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Restaurants'),
					);
////post end/// 
/// Deal 10 ////post start 10//
$image_array[] = "img7.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '0',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $cenddate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '3',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"	        		=> '1',					
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"file_name"					=> $destination_url.'dummy/img7.jpg',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '70',
					"current_price"	 			=> '110',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'White Glove Cleaning and Restoration Redeem From Home',
					"post_excerpt"	    =>	'A dirty home is like a guilty conscience its always nagging you from the background and prevents you from eating off the floor in peace. Expunge lingering worries from your abode with todays Groupon to White Glove Cleaning and Restoration. Todays deal is valid for homes within a 20 mile radius, homes outside the service area may be cleaned for an additional $10 fuel surcharge.
														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
					"post_content"	    =>	'A dirty home is like a guilty conscience its always nagging you from the background and prevents you from eating off the floor in peace. Expunge lingering worries from your abode with todays Groupon to White Glove Cleaning and Restoration. Todays deal is valid for homes within a 20 mile radius, homes outside the service area may be cleaned for an additional $10 fuel surcharge.
														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. 
 Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,				
					"post_category" =>	array('Services'),
					);
////post end/// 
/// Deal 11 ////post start 11//
$image_array[] = "img5.jpg" ;
$post_meta = array();
$cstartdate = date('Y m d H:i:s');
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"file_name"					=> $destination_url.'dummy/img5.jpg',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '49',
					"current_price"	 			=> '85',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Black Mountain Golf And Country Club',
					"post_excerpt"	    =>	'Like painting a portrait or fixing a computer, completing a round of golf is always more impressive when its done in the pouring rain. Enjoy equally impressive fair weathered fores with todays deal: for $49, you get 18 holes of golf with cart rental (up to an $85 value) and a large bucket of range balls (an $8 value) at Black Mountain Golf and Country Club in Henderson (up to a $93 total value).
The Horizon fairways keep golfers on their cleat tips with a blend of imposing boundaries, staunchly defended greens',
					"post_content"	    =>	'Like painting a portrait or fixing a computer, completing a round of golf is always more impressive when its done in the pouring rain. Enjoy equally impressive fair weathered fores with todays deal: for $49, you get 18 holes of golf with cart rental (up to an $85 value) and a large bucket of range balls (an $8 value) at Black Mountain Golf and Country Club in Henderson (up to a $93 total value).
The Horizon fairways keep golfers on their cleat tips with a blend of imposing boundaries, staunchly defended greens, and enticing birdie possibilities. A motorized golf cart lets players glide between holes, absorbing the scenic surrounding vistas while forgoing the strain of lugging a bag full of woods, irons, and bacon.														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. 
 Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,		
					"post_category" =>	array('Misc','Fun'),
					);
////post end/// 
/// Deal 12 ////post start 12//
$image_array[] = "img9.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=>  $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"file_name"					=> $destination_url.'dummy/img9.jpg',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '39',
					"current_price"	 			=> '60',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Chinese Footwear Deal',
					"post_excerpt"	    =>	'Without shoes, human feet would be forced to adapt, developing thick soles for protection and 6 inch heels to satisfy our innate need to tower over bears. Allay awkward foot evolution with todays deal for $39, you get $60 worth of womens shoes from Chinese Laundrys online boutique. 
					Lauded by style magazines, Chinese Laundrys array of footwear frames feet in styles ranging from elegant to everyday using eye catching lines and innovative materials',
					"post_content"	    =>	'Without shoes, human feet would be forced to adapt, developing thick soles for protection and 6 inch heels to satisfy our innate need to tower over bears. Allay awkward foot evolution with todays deal for $39, you get $60 worth of womens shoes from Chinese Laundrys online boutique. 
					Lauded by style magazines, Chinese Laundrys array of footwear frames feet in styles ranging from elegant to everyday using eye catching lines and innovative materials. Complement cocktail dresses by slipping toes into a choice of evening items, such as angelic, gold Willy Shimmer heels.
														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Misc'),
					"post_tags" =>	array('Tags','Sample Tags'),
					);
////post end/// 
/// Deal 13 ////post start 13//
$image_array[] = "img3.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"status"					=> '3',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"					=> $destination_url.'dummy/img3.jpg',
					"our_price"	        		=> '49',
					"current_price"	 			=> '300',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Unlimited Group Exercise Classes',
					"post_excerpt"	    =>	'Todays deal is super exciting. Though sweat indicates a great workout, inward sweating denotes an athlete with true humility. Flex a humble disposition with today exciting deal for $49, you get one month of unlimited group exercise classes at Phase 1 Sports (a $300 value including enrollment fee). 
 The Get Fit Circuit class pairs traditional exercises, such as pull ups and nose wiggles, with fast paced music to burn calories',
					"post_content"	    =>	'Todays deal is super exciting. Though sweat indicates a great workout, inward sweating denotes an athlete with true humility. Flex a humble disposition with today exciting deal for $49, you get one month of unlimited group exercise classes at Phase 1 Sports (a $300 value including enrollment fee). 
 The Get Fit Circuit class pairs traditional exercises, such as pull ups and nose wiggles, with fast paced music to burn calories, and the Strength & Conditioning Circuit enhances muscle endurance. Classes take place in Phase 2 Sports fully outfitted cardio and indoor areas mornings and evenings.														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category"     =>	array('Services'),
					);
////post end/// 
/// Deal 14 ////post start 14//
$image_array[] = "img10.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '20',
					"file_name"					=> $destination_url.'dummy/img10.jpg',
					"current_price"	 			=> '40',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Vehicle Wash or Detailing for Cheap',
					"post_excerpt"	    =>	'Automobiles need to be reminded to wash themselves. Drop a blatant hint to your lazy ride with todays Deal to Beyond Auto Detail in Henderson. 
					Our team of suds specialists brings out autos inner beauty with tender but thorough cleaning care. First, a gentle hand washing degunks mobiles, tidying up engines, headlights, and machine gun turrets. Our team of suds specialists can also perform a full service ride detailing, tending to both your cars body and heart. After a thorough hand washing, an interior and exterior scrubbing also shines windows, leather, tire walls, and doorjambs. ',
					"post_content"	    =>	'Automobiles need to be reminded to wash themselves. Drop a blatant hint to your lazy ride with todays Deal to Beyond Auto Detail in Henderson. 
					Our team of suds specialists brings out autos inner beauty with tender but thorough cleaning care. First, a gentle hand washing degunks mobiles, tidying up engines, headlights, and machine gun turrets. Our team of suds specialists can also perform a full service ride detailing, tending to both your cars body and heart. After a thorough hand washing, an interior and exterior scrubbing also shines windows, leather, tire walls, and doorjambs. 
														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. 
 In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
						"post_category" =>	array('Services'),
					"post_tags" =>	array('Tags','Sample Tags'),
					);
////post end/// 
/// Deal 15 ////post start 15//
$image_array[] = "img11.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"					=> $destination_url.'dummy/img11.jpg',
					"our_price"	        		=> '100',
					"current_price"	 			=> '200',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Four Night Stay for Two, Plus All Inclusive Food and Drinks',
					"post_excerpt"	    =>	'Bringing you the best deals as always. After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds. A minibar refreshes thirsty visitors with a one time welcome pack of soda, water, and beers. Travelers can surf through cable satellite channels on the rooms television set, and, for an extra free, store their valuables on a rented golf rack or in an electronic safe.
					The sparkling sands and cerulean waters of nearby Playa Dorada proffer a panoply of seaside activities, such as windsurfing, sailing, diving, and water skiing. History buffs undaunted by the two hour drive can ditch the surf.',
					"post_content"	    =>	'Bringing you the best deals as always. After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds. A minibar refreshes thirsty visitors with a one time welcome pack of soda, water, and beers. Travelers can surf through cable satellite channels on the rooms television set, and, for an extra free, store their valuables on a rented golf rack or in an electronic safe.
					The sparkling sands and cerulean waters of nearby Playa Dorada proffer a panoply of seaside activities, such as windsurfing, sailing, diving, and water skiing. History buffs undaunted by the two hour drive can ditch the surf.														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. 
 Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"     =>	array('Hotels'),
					);
////post end/// 
/// Deal 16 ////post start 16//
$image_array[] = "img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"file_name"					=> $destination_url.'dummy/img1.jpg',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '120',
					"current_price"	 			=> '200',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'The Jeffersons Stay in Deluxe Room',
					"post_excerpt"	    =>	'This time we are bringing you something awesome. Preseting an awesome stay at the Jeffersons. The historically curious can peruse the lobbys collection of Jefferson curios, including signed documents and period artifacts, before leisurely sauntering into a Deluxe room, where a skylight or city view, sitting area, and a king size bed decked in Porthault linens and a down duvet fold the past into a serene now. ',
					"post_content"	    =>	'This time we are bringing you something awesome. Preseting an awesome stay at the Jeffersons. The historically curious can peruse the lobbys collection of Jefferson curios, including signed documents and period artifacts, before leisurely sauntering into a Deluxe room, where a skylight or city view, sitting area, and a king size bed decked in Porthault linens and a down duvet fold the past into a serene now. 
					Plume, one of the hotels three restaurants, sculpts seasonal, rotating entrees anchored by the bounty of Monticellos kitchen gardens, such as monkfish osso from the spring dinner menu. 
					The sparkling sands and cerulean waters of nearby Playa Dorada proffer a panoply of seaside activities, such as windsurfing, sailing, diving, and water skiing. History buffs undaunted by the two hour drive can ditch the surf.														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. ',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Hotels'),
					);
////post end/// 
/// Deal 17 ////post start 17//
$image_array[] = "img2.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"				    => $destination_url.'dummy/img2.jpg',
					"our_price"	        		=> '15',
					"current_price"	 			=> '30',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Bike Rental Deal',
					"post_excerpt"	    =>	'Bike riding is fun and we know that. See the sights in two-wheeled fashion with todays deal: for $15, you get a one-day bike rental from Rays Bike Rentals (up to a $30 value). 
					Bringing you the best deals as always. After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds. A minibar refreshes thirsty visitors with a one time welcome pack of soda, water, and beers. Travelers can surf through cable satellite channels on the rooms television set, and, for an extra free, store their valuables on a rented golf rack or in an electronic safe.',
					"post_content"	    =>	'Bike riding is fun and we know that. See the sights in two-wheeled fashion with todays deal: for $15, you get a one-day bike rental from Rays Bike Rentals (up to a $30 value). 
					Bringing you the best deals as always. After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds. A minibar refreshes thirsty visitors with a one time welcome pack of soda, water, and beers. Travelers can surf through cable satellite channels on the rooms television set, and, for an extra free, store their valuables on a rented golf rack or in an electronic safe.
Childrens rentals come with helmets included, and adults can rent a helmet for an additional $2. All cycling captains receive locks to protect their bikes against curious birds or the bikes inherent curiousity. 
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Fun', 'Misc'),
					);
////post end/// 
/// Deal 18 ////post start 18//
$image_array[] = "img3.jpg" ;
$post_meta = array();
$cstartdate = date('Y m d H:i:s');
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"				=> $destination_url.'dummy/img3.jpg',
					"our_price"	        		=> '45',
					"current_price"	 			=> '99',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Vineyard And Winery Tour',
					"post_excerpt"	    =>	'Presting the vineyard tour. Guided by wine connoisseurs turned creators, Vineyard & Winery bottles a passionate appreciation for fine wine into every vintage made on its secluded countryside property. Tours gather at The Enoteca, the vineyards wine bar, before venturing out into the fields to see the green and purple bunches that start the oenophilic life cycle. Bringing you the best deals as always. Augment discussions with the winemakers themselves with bites of artisanal cheese and crusty bread or questions about the local art decorating the wine bar and upcoming slurpables.',
					"post_content"	    =>	'Presting the vineyard tour. Guided by wine connoisseurs turned creators, Vineyard & Winery bottles a passionate appreciation for fine wine into every vintage made on its secluded countryside property. Tours gather at The Enoteca, the vineyards wine bar, before venturing out into the fields to see the green and purple bunches that start the oenophilic life cycle. Bringing you the best deals as always. Augment discussions with the winemakers themselves with bites of artisanal cheese and crusty bread or questions about the local art decorating the wine bar and upcoming slurpables.
					After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds. A minibar refreshes thirsty visitors with a one time welcome pack of soda, water, and beers. Travelers can surf through cable satellite channels on the rooms television set, and, for an extra free, store their valuables on a rented golf rack or in an electronic safe.
					The sparkling sands and cerulean waters of nearby Playa Dorada proffer a panoply of seaside activities, such as windsurfing, sailing, diving, and water skiing. History buffs undaunted by the two hour drive can ditch the surf.														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category" =>	array('Tours'),
					"post_tags" =>	array('Tags','Sample Tags'),
					);
////post end/// 
/// Deal 19 ////post start 19//
$image_array[] = "img4.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"file_name" 	   		 	=> 'dummy/img4.jpg',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"max_purchases_user"		=> '2',
					"file_name"				=> $destination_url.'dummy/img4.jpg',
					"our_price"	        		=> '200',
					"current_price"	 			=> '400',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Academy of Ballroom Dancing',
					"post_excerpt"	    =>	'Dancing is the thing that makes humans special. Attract admirers more rhythmically and effectively with todays deal: for $200, you get two 50-minute private lessons (a $400 value). Once well versed in physical linguistics, students can put their knowledge to the test at three dance parties, navigating the exciting world of social dance etiquette by finding the appropriate socks for a sock hop, or politely convincing a wallflower to swing. Bringing you the best deals as always. After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds.',
					"post_content"	    =>	'Dancing is the thing that makes humans special. Attract admirers more rhythmically and effectively with todays deal: for $200, you get two 50-minute private lessons (a $400 value). Once well versed in physical linguistics, students can put their knowledge to the test at three dance parties, navigating the exciting world of social dance etiquette by finding the appropriate socks for a sock hop, or politely convincing a wallflower to swing. Bringing you the best deals as always. After a day on the links, the air conditioned, earth toned standard plus double room cossets overnighters in one king size bed or two queen size beds. A minibar refreshes thirsty visitors with a one time welcome pack of soda, water, and beers. Travelers can surf through cable satellite channels on the rooms television set, and, for an extra free, store their valuables on a rented golf rack or in an electronic safe.
					The sparkling sands and cerulean waters of nearby Playa Dorada proffer a panoply of seaside activities, such as windsurfing, sailing, diving, and water skiing. History buffs undaunted by the two hour drive can ditch the surf.														
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,	
					"post_category" =>	array('Services'),
					);
////post end/// 
/// Deal 20 ////post start 20//
$image_array[] = "img5.jpg" ;
$post_meta = array();
$post_meta = array(
					"is_expired"	       		=> '1',
					"no_of_coupon"	     		=> '4',
					"coupon_end_date_time"		=> $expdate,
					"coupon_website"	        => 'http://www.templatic.com',
					"coupon_start_date_time"	=> $cstartdate,
					"owner_name"	        	=> 'Templatic',
					"owner_email"	        	=> 'testtemplatic@gmail.com',
					"coupon_type"	        	=> '1',
					"coupon_link"	        	=> 'http://templatic.com',
					"status"					=> '3',
					"_edit_last"	        	=> '1',					
					"_edit_lock"	        	=> '1310982937:1',
					"coupon_website"	        => 'http://templatic.com',
					"tl_dummy_content"			=> '1',
					"min_purchases"	        	=> '1',
					"file_name"				=> $destination_url.'dummy/img5.jpg',
					"max_purchases_user"		=> '2',
					"our_price"	        		=> '15',
					"current_price"	 			=> '50',
					"coupon_entry"				=> 'coupon_entry_1',
					"coupon_code"				=> 'greatdiscount,getdiscount,friends,coupons',
					"thankyou_page_url"			=> 'http://templatic.com',
					);
$post_info[] = array(
					"post_title"	    =>	'Family Fun Center',
					"post_excerpt"	    =>	'Here starts your family fun. Playing laser tag with lasers is a safer alternative to playing freeze tag with liquid nitrogen. Battle friends the safe way with todays deal: for $15, you get seven games of Secret Agent LazerTag at Family Fun Center (a $50 value). All seven games can be redeemed at once by multiple users or during multiple visits. Bringing you the best deals as always. 
					The LazerTag arena at Family Fun Center pits laser and sensor equipped fighters against one another in a three tiered spy themed battlefield. Like a wedding cake, but not as edible, the secret agent style layers pack enough excitement and black tie elegance to keep even the most finicky great uncles from boredom.',
					"post_content"	    =>	'Here starts your family fun. Playing laser tag with lasers is a safer alternative to playing freeze tag with liquid nitrogen. Battle friends the safe way with todays deal: for $15, you get seven games of Secret Agent LazerTag at Family Fun Center (a $50 value). All seven games can be redeemed at once by multiple users or during multiple visits. Bringing you the best deals as always. 
					The LazerTag arena at Family Fun Center pits laser and sensor equipped fighters against one another in a three tiered spy themed battlefield. Like a wedding cake, but not as edible, the secret agent style layers pack enough excitement and black tie elegance to keep even the most finicky great uncles from boredom.
 Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et. Donec nec libero.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category" =>	array('Fun'),
					"post_tags" =>	array('Tags','Sample Tags'),
					);
////post end/// 
insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{

	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='".CUSTOM_POST_TYPE1."' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_excerpt'] = $post_info_arr['post_excerpt'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = CUSTOM_POST_TYPE1;
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy=CUSTOM_CATEGORY_TYPE1);
			wp_set_object_terms($last_postid,$post_info_arr['post_tags'], $taxonomy='cartags');

			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//====================================================================================//
/////////////////////////////////////////////////
$pages_array = array(array(PAGE_TEMP_MENU_TEXT,ADV_SEARCH_MENU_TEXT,ARCHIVE_TEXT,FULL_WIDTH_MENU_TEXT,LEFT_SIDEBAR_MENU_TEXT,SHORTCODES_MENU_TEXT,SITEMAP_MENU_TEXT,CONTACT_MENU_TEXT),array(ABOUT_US_TEXT,SHIP_MENU_TEXT));
$page_info_arr = array();
$page_info_arr['Page Templates'] = '
In WordPress, you can write either posts or pages. When you writing a regular blog entry, you write a post. Posts automatically appear in reverse chronological order on your blog home page. Pages, on the other hand, are for content such as "About Me," "Contact Me," etc. Pages live outside of the normal blog chronology, and are often used to present information about yourself or your site that is somehow timeless -- information that is always applicable. You can use Pages to organize and manage any amount of content. WordPress can be configured to use different Page Templates for different Pages. 

To create a new Page, log in to your WordPress admin with sufficient admin privileges to create new page. Select the Pages &gt; Add New option to begin writing a new Page.

<blockquote>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</blockquote>

In WordPress, you can write either posts or pages. When you writing a regular blog entry, you write a post. Posts automatically appear in reverse chronological order on your blog home page. Pages, on the other hand, are for content such as "About Me," "Contact Me," etc. Pages live outside of the normal blog chronology, and are often used to present information about yourself or your

<ul>
	<li>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapi</li>
<li>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapi</li>
<li>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapi</li>
</ul>

In WordPress, you can write either posts or pages. When you writing a regular blog entry, you write a post. Posts automatically appear in reverse chronological order on your blog home page. Pages, on the other hand, are for content such as "About Me," "Contact Me," etc. Pages live outside of the normal blog chronology, and are often used to present information about yourself or your

<ol>
	<li>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapi</li>
<li>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapi</li>
<li>Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapi</li>
</ol>





Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.


';
$page_info_arr['Advanced Search'] = '
This is the Advanced Search page template. See how it looks. Just select this template from the page attributes section and you&rsquo;re good to go.
';
$page_info_arr['Archives'] = '
This is Archives page template. Just select it from page templates section and you&rsquo;re good to go.
';
$page_info_arr['Shortcodes'] = '
This theme comes with built in shortcodes. The shortcodes make it easy to add stylised content to your site, plus they&rsquo;re very easy to use. Below is a list of shortcodes which you will find in this theme.
[ Download ]
[Download] Download: Look, you can use me for highlighting some special parts in a post. I can make download links more highlighted. [/Download]
[ Alert ]
[Alert] Alert: Look, you can use me for highlighting some special parts in a post. I can be used to alert to some special points in a post. [/Alert]
[ Note ]
[Note] Note: Look, you can use me for highlighting some special parts in a post. I can be used to display a note and thereby bringing attention.[/Note]
[ Info ]
[Info] Info: Look, you can use me for highlighting some special parts in a post. I can be used to provide any extra information. [/Info]
[ Author Info ]
[Author Info]<img src="'.'dummy/no-avatar.png" alt="" />
<h4>About The Author</h4>
Use me for adding more information about the author. You can use me anywhere within a post or a page, i am just awesome. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing.
[/Author Info]
<h3>Button List</h3>
[ Small_Button class="red" ]
[Small_Button class="red"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="grey"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="black"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="blue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="lightblue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="purple"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="magenta"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="green"]<a href="#">Button Text</a>[/Small_Button]  [Small_Button class="orange"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="yellow"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="pink"]<a href="#">Button Text</a>[/Small_Button]
<hr />
<h3>Icon list view</h3>
[ Icon List ]
[Icon List]
<ul>
	<li> Use the shortcode to add this attractive unordered list</li>
	<li> SEO options in every page and post</li>
	<li> 5 detailed color schemes</li>
	<li> Fully customizable front page</li>
	<li> Excellent Support</li>
	<li> Theme Guide &amp; Tutorials</li>
	<li> PSD File Included with multiple use license</li>
	<li> Gravatar Support &amp; Threaded Comments</li>
	<li> Inbuilt custom widgets</li>
	<li> 30 built in shortcodes</li>
	<li> 8 Page templates</li>
	<li>Valid, Cross browser compatible</li>
</ul>
[/Icon List]
<h3>Dropcaps Content</h3>
[ Dropcaps ] 
[Dropcaps] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

[Dropcaps] Dropcaps can be so useful sometimes. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

<h3>Content boxes</h3>
We, the content boxes can be used to highlight special parts in the post. We can be used anywhere, just use the particular shortcode and we will be there.
[ Normal_Box ]
[Normal_Box]<h3>Normal Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Normal_Box]

[ Warning_Box ]
[Warning_Box]<h3>Warring Box</h3>
This is how a warning content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Warning_Box]

[ Download_Box ]
[Download_Box]<h3>Download Box</h3>
This is how a download content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Download_Box]

[ About_Box ]
[About_Box]<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

[/About_Box]

[ Info_Box ]

[Info_Box]<h3>Info Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Info_Box]

[ Alert_Box ]
[Alert_Box]<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Alert_Box]

[Info_Box_Equal]<h3>Info Box</h3>
This is how info content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of Info box.<strong> [ Info_Box_Equal ]</strong>
[/Info_Box_Equal]


[Alert_Box_Equal]<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of alert box.<strong> [ Alert_Box_Equal ]</strong>


[/Alert_Box_Equal]

[About_Box_Equal]<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, molestie in, commodo  porttitor. Use this shortcode for this type of about box. <strong>[ About_Box_Equal ]</strong>

[/About_Box_Equal]


[One_Half]<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half ]</strong>

[/One_Half]


[One_Half_Last]<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half_Last ]</strong>

[/One_Half_Last]



[One_Third]<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam ut lacus. <strong>[ One_Third ]</strong>

[/One_Third]


[One_Third]<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in. Commodo  porttitor, felis. Nam lacus. <strong> [ One_Third ]</strong>

[/One_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. <strong>[ One_Third_Last ]</strong>

[/One_Third_Last]



[One_Fourth]<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth]<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong> [ One_Fourth ]</strong>

[/One_Fourth]


[One_Fourth]<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth_Last]<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth_Last ]</strong>

[/One_Fourth_Last]



[One_Third]<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus. <strong>[ One_Third ]</strong>

[/One_Third]



[Two_Third_Last]<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus.  <strong> [ Two_Third_Last ]</strong>

[/Two_Third_Last]



[Two_Third]<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. <strong>[ Two_Third ]</strong>

[/Two_Third]



[One_Third_Last]<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, commodo  porttitor, felis.  <strong> [ One_Third_Last ]</strong>

[/One_Third_Last]
';
$page_info_arr['Full Width'] = '
Do you know how easy it is to use Full Width page template ? Just add a new page and select full width page template and you are good to go. Here is a preview of this easy to use page template.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

See, there no sidebar in this template, and that why we call this a full page template. Yes, its this easy to use page templates. Just write any content as per your wish.
';
$page_info_arr['Left Sidebar Page'] = '
This is <strong>left sidebar page template</strong>. To use this page template, just select - page left sidebar template from Pages and publish the post. Its so easy using a page template.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus.

Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam.
<blockquote>Blockquote text looks like this</blockquote>
See, using left sidebar page template is so easy. Really.
';
$page_info_arr['Sitemap'] = '
See, how easy is to use page templates. Just add a new page and select <strong>Sitemap</strong> from the page templates section. Easy peasy, isn&rsquo;t it.
';
$page_info_arr['Contact Us'] = '
<p>What do you think about this Contact page template? Have anything to say, any suggestions or any queries ? Feel free to contact us, we&rsquo;re here to help you. You can write any text in this page and use the Contact Us page template. Its very easy to use page templates. Our theme includes many such useful page templates.</p>
<p>We are located at:<br />
18th and Walnut Streets,<br />
Philadelphia, PA 19103</p>
<p>Call 24/7<br />
989-8989-789</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare. </p>
';
$page_info_arr['About Us'] = '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus.
';

$page_info_arr['Shipping &amp; Handling'] = '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus.
';


set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{ 
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{ 
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_excerpt'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_excerpt'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}
		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				$post_name = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					echo '';
				}else
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('siteurl')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}

//=====================================================================
$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Advanced Search' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_advanced_search.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Web Hosting Plan' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Shortcodes' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_archives.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Full Width' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Left Sidebar Page' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_left_sidebar_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sitemap' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_sitemap.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contact Us' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_contact.php' );

$wp_upload_dir = wp_upload_dir();
$basedir = $wp_upload_dir['basedir'];
$baseurl = $wp_upload_dir['baseurl'];
$folderpath = $destination_path."/dummy/";
full_copy( TEMPLATEPATH."/images/dummy/", $folderpath );
function full_copy( $source, $target ) 
{
	$imagepatharr = explode('/',str_replace(TEMPLATEPATH,'',$target));
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path = ABSPATH.$imagepatharr[$i]."/";
		  if (!file_exists($year_path)){
			 @mkdir($year_path, 0777);
		  }     
		}
	}
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			@copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		@copy( $source, $target );
	}
}


///////////////////////////////////////////////////////////////////////////////////
//====================================================================================//
/*
echo "<pre>";
//print_r(get_option('sidebars_widgets'));
print_r(get_option('widget_widget_location_map'));
exit;  
*/

/////////////// WIDGET SETTINGS START ///////////////

$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();

////////////////Top Navigation////////////////////// 
$widget_loginuser = array();
$widget_loginuser[1] = array(
					"title"	=>	'',
					
					);						
$widget_loginuser['_multiwidget'] = '1';
update_option('widget_widget_loginuser',$widget_loginuser);
$widget_loginuser = get_option('widget_widget_loginuser');
krsort($widget_loginuser);
foreach($widget_loginuser as $key1=>$val1)
{
	$widget_loginuser_key = $key1;
	if(is_int($widget_loginuser_key))
	{
		break;
	}
}

$sidebars_widgets["header_above"] = array("widget_loginuser-$widget_loginuser_key");

////////////////Home Above////////////////////// 
$text = array();
$text[1] = array(
					"title"	=>	'People would normally want to add a SEO / copy here.',
					"text"	=>	'<p>And it will go with a nice tagline, subtitle or whatever. Just below the main copy.</p>',
					);						
$text['_multiwidget'] = '1';
update_option('widget_text',$text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key1=>$val1)
{
	$text_key = $key1;
	if(is_int($text_key))
	{
		break;
	}
}

$sidebars_widgets["home_above"] = array("text-$text_key");

////////////////Home Below////////////////////// 
$onecolumnslist = array();
$onecolumnslist[1] = array(
					"title"	=>	'Deals',
					"category"	=>	'',
					"post_number"	=>	'3',
					);						
$onecolumnslist['_multiwidget'] = '1';
update_option('widget_onecolumnslist',$onecolumnslist);
$onecolumnslist = get_option('widget_onecolumnslist');
krsort($onecolumnslist);
foreach($onecolumnslist as $key1=>$val1)
{
	$onecolumnslist_key = $key1;
	if(is_int($onecolumnslist_key))
	{
		break;
	}
}

$sidebars_widgets["home_below"] = array("onecolumnslist-$onecolumnslist_key");


////////////////Single Post Below////////////////////// 
$widget_get_new_deal = array();
$widget_get_new_deal[1] = array(
					"id"	=>	'templatic',
					"title"	=>	'Get new deals every day!',
					"text"	=>	'Subscribe to DailyDeal Newsletter and get daily alerts',
					);						
$widget_get_new_deal['_multiwidget'] = '1';
update_option('widget_widget_get_new_deal',$widget_get_new_deal);
$widget_get_new_deal = get_option('widget_widget_get_new_deal');
krsort($widget_get_new_deal);
foreach($widget_get_new_deal as $key1=>$val1)
{
	$widget_get_new_deal_key = $key1;
	if(is_int($widget_get_new_deal_key))
	{
		break;
	}
}

$sidebars_widgets["single_post_below"] = array("widget_get_new_deal-$widget_get_new_deal_key");


////////////////Footer1////////////////////// 
$text2 = array();
$text2 = get_option('widget_text');
$text2[2] = array(
					"title"	=>	'Shipping &amp; Handling',
					"text"	=>	'<p>Free delivery on all items if your total order amount is more than $100. Otherwise $10 is charged as delivery charges.</p> <p>The estimated time of delivery is mentioned on every page. It may differ from one item to another. If you have any doubt, then feel free to contact us. <a href="#">Read more &raquo;</a></p>',
					);						
$text2['_multiwidget'] = '1';
update_option('widget_text',$text2);
$text2 = get_option('widget_text');
krsort($text2);
foreach($text2 as $key1=>$val1)
{
	$text_key2 = $key1;
	if(is_int($text_key2))
	{
		break;
	}
}

$sidebars_widgets["footer1"] = array("text-$text_key2");

////////////////Footer2////////////////////// 
$text3 = array();
$text3 = get_option('widget_text');
$text3[3] = array(
					"title"	=>	'Submit your deal',
					"text"	=>	'<p>We are the most popular Deal website run by users like you. Submitting a deal will increase the chances of more sales and your product will get more exposure.</p><p>Yes, you are submitting the deal on the best site of the planet. Increase your sales revenue drastically by submitting your deal. <a href="'.site_url().'/?ptype=dealform">Submit Now &raquo;</a></p>',
					);						
$text3['_multiwidget'] = '1';
update_option('widget_text',$text3);
$text3 = get_option('widget_text');
krsort($text3);
foreach($text3 as $key1=>$val1)
{
	$text_key3 = $key1;
	if(is_int($text_key3))
	{
		break;
	}
}

$sidebars_widgets["footer2"] = array("text-$text_key3");

////////////////Footer3////////////////////// 
$text4 = array();
$text4 = get_option('widget_text');
$text4[4] = array(
					"title"	=>	ABOUT_US_TEXT,
					"text"	=>	'<p>Our DailyDeal theme lets you build a Deal website with brand new looks and complete functionality integrated.</p><p>This theme is just your one stop shop and includes everything. No need to buy any Plugins or anything extra. Even payment gateways are included. <a href="#">Read more &raquo;</a></p>',
					);						
$text4['_multiwidget'] = '1';
update_option('widget_text',$text4);
$text4 = get_option('widget_text');
krsort($text4);
foreach($text4 as $key1=>$val1)
{
	$text_key4 = $key1;
	if(is_int($text_key4))
	{
		break;
	}
}

$sidebars_widgets["footer3"] = array("text-$text_key4");



////////////////Footer Above////////////////////// 
$widget_socialbookmark = array();
$widget_socialbookmark[1] = array(
					"facebook_title"	=>	'DailyDeal on Facebook',
					"facebook"			=>	'http://www.facebook.com/templatic',
					"twitter_title"		=>	'DailyDeal on Twitter',
					"twitter"			=>	'http://twitter.com/templatic',
					"rss_title"			=>	'DailyDeal Rss Feed',
					"rss"				=>	'http://feeds.feedburner.com/Templatic',					
					);						
$widget_socialbookmark['_multiwidget'] = '1';
update_option('widget_widget_socialbookmark',$widget_socialbookmark);
$widget_socialbookmark = get_option('widget_widget_socialbookmark');
krsort($widget_socialbookmark);
foreach($widget_socialbookmark as $key1=>$val1)
{
	$widget_socialbookmark_key = $key1;
	if(is_int($widget_socialbookmark_key))
	{
		break;
	}
}

$sidebars_widgets["footer_above"] = array("widget_socialbookmark-$widget_socialbookmark_key");


////////////////Contact Googlemap////////////////////// 
$widget_location_map = array();
$widget_location_map[1] = array(
					"title"	=>	'',
					"address"	=>	'18th and Walnut Streets, Philadelphia, PA 19103',
					"address_latitude"	=>	'39.955823048131286',
					"address_longitude"	=>	'-75.14408111572266',
					"map_width"	=>	'300',
					"map_height"	=>	'300',
					"map_type"	=>	'ROADMAP',
					"scale"	=>	'10',									
					);				
$widget_location_map['_multiwidget'] = '1';
update_option('widget_widget_location_map',$widget_location_map);
$widget_location_map = get_option('widget_widget_location_map');
krsort($widget_location_map);
foreach($widget_location_map as $key1=>$val1)
{
	$widget_location_map_key = $key1;
	if(is_int($widget_location_map_key))
	{
		break;
	}
}

$sidebars_widgets["contact_googlemap"] = array("widget_location_map-$widget_location_map_key");


////////////////Sidebar 1//////////////////////

$search = array();
$search[1] = array(
					"title"	=>	'',
					);						
$search['_multiwidget'] = '1';
update_option('widget_search',$search);
$search = get_option('widget_search');
krsort($search);
foreach($search as $key1=>$val1)
{
	$search_key = $key1;
	if(is_int($search_key))
	{
		break;
	}
}


$widget_login = array();
$widget_login[1] = array(
					"title"	=>	'Member Login',					
					);						
$widget_login['_multiwidget'] = '1';
update_option('widget_widget_login',$widget_login);
$widget_login = get_option('widget_widget_login');
krsort($widget_login);
foreach($widget_login as $key1=>$val1)
{
	$widget_login_key = $key1;
	if(is_int($widget_login_key))
	{
		break;
	}
}


$widget_taxonomy = array();
$widget_taxonomy[1] = array(
					"title"	=>	'Deals by Category',
					"taxonomy"	=>	'seller_category',
					"count"	=>	'1',
					"hierarchical"	=>	'0',
					"dropdown"	=>	'0',
					);				
$widget_taxonomy['_multiwidget'] = '1';
update_option('widget_widget_taxonomy',$widget_taxonomy);
$widget_taxonomy = get_option('widget_widget_taxonomy');
krsort($widget_taxonomy);
foreach($widget_taxonomy as $key1=>$val1)
{
	$widget_taxonomy_key = $key1;
	if(is_int($widget_taxonomy_key))
	{
		break;
	}
}

$tag_cloud = array();
$tag_cloud[1] = array(
					"title"		  	=>	'Tags',					
					"taxonomy"		=>	'post_tag',					
					);				
$tag_cloud['_multiwidget'] = '1';
update_option('widget_tag_cloud',$tag_cloud);
$tag_cloud = get_option('widget_tag_cloud');
krsort($tag_cloud);
foreach($tag_cloud as $key1=>$val1)
{
	$tag_cloud_key = $key1;
	if(is_int($tag_cloud_key))
	{
		break;
	}
}

$widget_get_subscribe_option = array();
$widget_get_subscribe_option[1] = array(				
					"opt_subscrib"		=>	'constant_contact',					
					);				
$widget_get_subscribe_option['_multiwidget'] = '1';
update_option('widget_widget_get_subscribe_option',$widget_get_subscribe_option);
$widget_get_subscribe_option = get_option('widget_widget_get_subscribe_option');
krsort($widget_get_subscribe_option);
foreach($widget_get_subscribe_option as $key1=>$val1)
{
	$widget_get_subscribe_option_key = $key1;
	if(is_int($widget_get_subscribe_option_key))
	{
		break;
	}
}


$sidebars_widgets["sidebar1"] = array("search-$search_key","widget_login-$widget_login_key","widget_taxonomy-$widget_taxonomy_key","tag_cloud-$tag_cloud_key","widget_get_subscribe_option-$widget_get_subscribe_option_key");





//echo '<pre>'; print_r($sidebars_widgets);exit;
//===============================================================================
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END /////////////

//=====================================================================
/////////////// Design Settings START ///////////////


// General settings start  /////
update_option("ptthemes_alt_stylesheet",'1-default');
update_option("ptthemes_show_blog_title",'No');
update_option("ptthemes_feedburner_url",'http://feeds2.feedburner.com/templatic');
update_option("ptthemes_feedburner_id",'templatic/ekPs');
update_option("ptthemes_tweet_button",'Yes');
update_option("ptthemes_facebook_button",'Yes');
update_option("ptthemes_date_format",'yyyy-mm-dd');
update_option("pttheme_contact_email",'info@mysite.com');
update_option("ptthemes_breadcrumbs",'Yes');
update_option("ptthemes_auto_install",'No');
update_option("ptthemes_postcontent_full",'Excerpt');
update_option("ptthemes_content_excerpt_count",'40');
update_option("ptthemes_content_excerpt_readmore",__('Read More &rarr;','templatic'));
update_option("pttthemes_captcha",'Disable');
update_option("ptttheme_google_map_opt",'Disable');
update_option("ptthemes_dealcomments",'Yes');
update_option("ptthemes_timthumb",'Yes');
update_option("pttthemes_send_mail",'Enable');
update_option("ptttheme_fb_opt",'Disable');
update_option("ptttheme_view_opt",'List View');
update_option("ptttheme_currency_symbol",'$');

// General settings End  /////

// Navigation settings
update_option("ptthemes_main_pages_nav_enable",'Activate');
update_option("pttthemes_submit_deal_link",'Enable');
// Navigation settings

// Seo option
update_option("pttheme_seo_hide_fields",'No');
update_option("ptthemes_use_third_party_data",'No');
// Seo option 

// Post  option
update_option("ptthemes_home_page",'6');
update_option("ptthemes_cat_page",'6');
update_option("ptthemes_search_page",'6');
update_option("ptthemes_pagination",'Default + WP Page-Navi support');
// Post  option 

//Navigation  
$page_id1 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'About' and post_type='page'");
$page_id2 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contcat Us' and post_type='page'");
$page_id3 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sub Page 1' and post_type='page'");
$page_id4 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sub Page 2' and post_type='page'");

$page_id5 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
$page_id6 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Gallery' and post_type='page'");
$page_id7 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Site Map' and post_type='page'");
$page_id8 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Left Sidebar' and post_type='page'");

$pages_ids = $page_id1.",".$page_id2.",".$page_id3.",".$page_id4.",".$page_id5.",".$page_id6.",".$page_id7.",".$page_id8;
update_option("ptthemes_top_pages_nav",$pages_ids);
//Navigation  

// Page Layout
update_option("ptthemes_page_layout",'Page 2 column - Right Sidebar');
update_option("ptthemes_bottom_options",'Three Column');
// Page Layout

if($_REQUEST['dump']==1){
echo "<script>";
echo "window.location.href='".get_option('siteurl')."/wp-admin/themes.php?dummy_insert=1'";
echo "</script>";
}
/////////////// Design Settings END ///////////////
//====================================================================================//
?>