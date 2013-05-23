# HOW TO USE THIS FRAMEWORK

### 1. How to adapt logo, title, footer and navigation
To change the logo of the framework you need to go to site/themes/herotheme and
add a picture of your new logo. And after that you need to go to config.php where
you change the logo-specifiactions to the name of your new logo, aswell as changing
the width and height so that it is applicable for the new logo. At the same place
in the config-file you can also change the text of the footer and the sitetitle.

To change make changes to the navigationbar you need to go upp a little bit in
the config.php-file and there you can change the name of your different sites
in the navbar. You can 

### 2. Create a blog
In the webinterface there is already a blog, where there is a few blogposts 
created already. To edit and create your own blog and blogposts you first need
to navigate to the site that says "about me", where you click on view all. And 
from there you can click on "create content". To learn about how to fill in the
form to create your content I suggest that you look on the posts already created.
When you create a blogpost you first write the title, and then the key. I suggest
you name the key to the same name as your title but with small letters and hyphens
between words instead of spaces. In the content you just write about whatever you
want and in type you write "post". This is necessary for the framework to know
what type of information you are putting in. And then for filter I recommend you
use plain while it is just plain text that you'd want to present. 


### 3. Create a page
In the website there is already a page called "about me", and also a few other
pages if you look att the conent-page. You can learn some by clicking edit on
the pages that are there already. Click edit on the 'home' page, and you will see
that title has pretty much the same function as for blogposts. The key though is
what the config goes after in the navbar, you can see that config. If the key says
home that is what the navbar will react to. The content then is the content, and
for type you write 'page'. You could also use some filters here. If you write 
bbcode you will get the possibility to add som formatting, and the most common
are showed in the example. The other example with htmlpurify makes it possible for
you to use html-tags, though no other, for example it does not allow javascript.

This should get you going. Next step could be for you to add another static page
to your navbar by using a matching key to a new navigationalternative that you
should be able to figure out how to create quite easy.
