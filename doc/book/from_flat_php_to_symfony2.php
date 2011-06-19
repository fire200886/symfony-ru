<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">От плоского PHP кода до Symfony2</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="when-flat-php-meets-symfony">
      <h1>От плоского PHP кода до Symfony2<a class="headerlink" href="#when-flat-php-meets-symfony" title="Permalink to this headline">¶</a></h1>
      <p><strong>Почему Symfony2 лучше, чем просто открыть файл и написать на плоском PHP?</strong></p>
      <p>Если вы никогда не пользовались PHP-фреймворком, не знакомы с философией MVC
      или вам просто интересна вся эта <em>шумиха</em> около Symfony2, то эта глава для вас.
      Вместо того чтобы <em>рассказывать</em> о том, что Symfony2 позволяет разрабатывать быстрее и лучше
      вы увидите это сами.</p>
      <p>В этой главе вы напишите простое приложение на плоском PHP и проведете рефакторинг, чтобы сделать его более организованным.
      Вы совершите путешествие во времени и узнаете почему индустрия веб-разработки движется туда, где она сейчас.</p>
      <p>В конце вы увидите как Symfony2 может спасти вас от рутинных задач и вернуть контроль над кодом.</p>
      <div class="section" id="a-simple-blog-in-flat-php">
	<h2>Простой блог на плоском PHP<a class="headerlink" href="#a-simple-blog-in-flat-php" title="Permalink to this headline">¶</a></h2>
	<p>In this chapter, you'll build the token blog application using only flat PHP.
	  To begin, create a single page that displays blog entries that have been
	  persisted to the database. Writing in flat PHP is quick and dirty:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// index.php</span>

<span class="nv">$link</span> <span class="o">=</span> <span class="nb">mysql_connect</span><span class="p">(</span><span class="s1">'localhost'</span><span class="p">,</span> <span class="s1">'myuser'</span><span class="p">,</span> <span class="s1">'mypassword'</span><span class="p">);</span>
<span class="nb">mysql_select_db</span><span class="p">(</span><span class="s1">'blog_db'</span><span class="p">,</span> <span class="nv">$link</span><span class="p">);</span>

<span class="nv">$result</span> <span class="o">=</span> <span class="nb">mysql_query</span><span class="p">(</span><span class="s1">'SELECT id, title FROM post'</span><span class="p">,</span> <span class="nv">$link</span><span class="p">);</span>
<span class="cp">?&gt;</span>

<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span>List of Posts<span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="nt">&lt;h1&gt;</span>List of Posts<span class="nt">&lt;/h1&gt;</span>
        <span class="nt">&lt;ul&gt;</span>
            <span class="cp">&lt;?php</span> <span class="k">while</span> <span class="p">(</span><span class="nv">$row</span> <span class="o">=</span> <span class="nb">mysql_fetch_assoc</span><span class="p">(</span><span class="nv">$result</span><span class="p">))</span><span class="o">:</span> <span class="cp">?&gt;</span>
            <span class="nt">&lt;li&gt;</span>
                <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"/show.php?id=</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$row</span><span class="p">[</span><span class="s1">'id'</span><span class="p">]</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;</span>
                    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$row</span><span class="p">[</span><span class="s1">'title'</span><span class="p">]</span> <span class="cp">?&gt;</span>
                <span class="nt">&lt;/a&gt;</span>
            <span class="nt">&lt;/li&gt;</span>
            <span class="cp">&lt;?php</span> <span class="k">endwhile</span><span class="p">;</span> <span class="cp">?&gt;</span>
        <span class="nt">&lt;/ul&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>

<span class="cp">&lt;?php</span>
<span class="nb">mysql_close</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>That's quick to write, fast to execute, and, as your app grows, impossible
	  to maintain. There are several problems that need to be addressed:</p>
	<ul class="simple">
	  <li><strong>No error-checking</strong>: What if the connection to the database fails?</li>
	  <li><strong>Poor organization</strong>: If the application grows, this single file will become
	    increasingly unmaintainable. Where should you put code to handle a form
	    submission? How can you validate data? Where should code go for sending
	    emails?</li>
	  <li><strong>Difficult to reuse code</strong>: Since everything is in one file, there's no
	    way to reuse any part of the application for other "pages" of the blog.</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Another problem not mentioned here is the fact that the database is
	      tied to MySQL. Though not covered here, Symfony2 fully integrates <a class="reference external" href="http://www.doctrine-project.org">Doctrine</a>,
	      a library dedicated to database abstraction and mapping.</p>
	</div></div>
	<p>Let's get to work on solving these problems and more.</p>
	<div class="section" id="isolating-the-presentation">
	  <h3>Isolating the Presentation<a class="headerlink" href="#isolating-the-presentation" title="Permalink to this headline">¶</a></h3>
	  <p>The code can immediately gain from separating the application "logic" from
	    the code that prepares the HTML "presentation":</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// index.php</span>

<span class="nv">$link</span> <span class="o">=</span> <span class="nb">mysql_connect</span><span class="p">(</span><span class="s1">'localhost'</span><span class="p">,</span> <span class="s1">'myuser'</span><span class="p">,</span> <span class="s1">'mypassword'</span><span class="p">);</span>
<span class="nb">mysql_select_db</span><span class="p">(</span><span class="s1">'blog_db'</span><span class="p">,</span> <span class="nv">$link</span><span class="p">);</span>

<span class="nv">$result</span> <span class="o">=</span> <span class="nb">mysql_query</span><span class="p">(</span><span class="s1">'SELECT id, title FROM post'</span><span class="p">,</span> <span class="nv">$link</span><span class="p">);</span>

<span class="nv">$posts</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span>
<span class="k">while</span> <span class="p">(</span><span class="nv">$row</span> <span class="o">=</span> <span class="nb">mysql_fetch_assoc</span><span class="p">(</span><span class="nv">$result</span><span class="p">))</span> <span class="p">{</span>
    <span class="nv">$posts</span><span class="p">[]</span> <span class="o">=</span> <span class="nv">$row</span><span class="p">;</span>
<span class="p">}</span>

<span class="nb">mysql_close</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>

<span class="c1">// include the HTML presentation code</span>
<span class="k">require</span> <span class="s1">'templates/list.php'</span><span class="p">;</span>
	    </pre></div>
	  </div>
	  <p>The HTML code is now stored in a separate file (<tt class="docutils literal"><span class="pre">templates/list.php</span></tt>), which
	    is primarily an HTML file that uses a template-like PHP syntax:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span>List of Posts<span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="nt">&lt;h1&gt;</span>List of Posts<span class="nt">&lt;/h1&gt;</span>
        <span class="nt">&lt;ul&gt;</span>
            <span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$posts</span> <span class="k">as</span> <span class="nv">$post</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
            <span class="nt">&lt;li&gt;</span>
                <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"/read?id=</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'id'</span><span class="p">]</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;</span>
                    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'title'</span><span class="p">]</span> <span class="cp">?&gt;</span>
                <span class="nt">&lt;/a&gt;</span>
            <span class="nt">&lt;/li&gt;</span>
            <span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
        <span class="nt">&lt;/ul&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	    </pre></div>
	  </div>
	  <p>By convention, the file that contains all of the application logic - <tt class="docutils literal"><span class="pre">index.php</span></tt> -
	    is known as a "controller". The term <a class="reference internal" href="../glossary.html#term-controller"><em class="xref std std-term">controller</em></a> is a word you'll hear
	    a lot, regardless of the language or framework you use. It refers simply
	    to the area of <em>your</em> code that processes user input and prepares the response.</p>
	  <p>In this case, our controller prepares data from the database and then includes
	    a template to present that data. With the controller isolated, you could
	    easily change <em>just</em> the template file if you needed to render the blog
	    entries in some other format (e.g. <tt class="docutils literal"><span class="pre">list.json.php</span></tt> for JSON format).</p>
	</div>
	<div class="section" id="isolating-the-application-domain-logic">
	  <h3>Isolating the Application (Domain) Logic<a class="headerlink" href="#isolating-the-application-domain-logic" title="Permalink to this headline">¶</a></h3>
	  <p>So far the application contains only one page. But what if a second page
	    needed to use the same database connection, or even the same array of blog
	    posts? Refactor the code so that the core behavior and data-access functions
	    of the application are isolated in a new file called <tt class="docutils literal"><span class="pre">model.php</span></tt>:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// model.php</span>

<span class="k">function</span> <span class="nf">open_database_connection</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$link</span> <span class="o">=</span> <span class="nb">mysql_connect</span><span class="p">(</span><span class="s1">'localhost'</span><span class="p">,</span> <span class="s1">'myuser'</span><span class="p">,</span> <span class="s1">'mypassword'</span><span class="p">);</span>
    <span class="nb">mysql_select_db</span><span class="p">(</span><span class="s1">'blog_db'</span><span class="p">,</span> <span class="nv">$link</span><span class="p">);</span>

    <span class="k">return</span> <span class="nv">$link</span><span class="p">;</span>
<span class="p">}</span>

<span class="k">function</span> <span class="nf">close_database_connection</span><span class="p">(</span><span class="nv">$link</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nb">mysql_close</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>
<span class="p">}</span>

<span class="k">function</span> <span class="nf">get_all_posts</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$link</span> <span class="o">=</span> <span class="nx">open_database_connection</span><span class="p">();</span>

    <span class="nv">$result</span> <span class="o">=</span> <span class="nb">mysql_query</span><span class="p">(</span><span class="s1">'SELECT id, title FROM post'</span><span class="p">,</span> <span class="nv">$link</span><span class="p">);</span>
    <span class="nv">$posts</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span>
    <span class="k">while</span> <span class="p">(</span><span class="nv">$row</span> <span class="o">=</span> <span class="nb">mysql_fetch_assoc</span><span class="p">(</span><span class="nv">$result</span><span class="p">))</span> <span class="p">{</span>
        <span class="nv">$posts</span><span class="p">[]</span> <span class="o">=</span> <span class="nv">$row</span><span class="p">;</span>
    <span class="p">}</span>
    <span class="nx">close_database_connection</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>

    <span class="k">return</span> <span class="nv">$posts</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The filename <tt class="docutils literal"><span class="pre">model.php</span></tt> is used because the logic and data access of
		an application is traditionally known as the "model" layer. In a well-organized
		application, the majority of the code representing your "business logic"
		should live in the model (as opposed to living in a controller). And unlike
		in this example, only a portion (or none) of the model is actually concerned
		with accessing a database.</p>
	  </div></div>
	  <p>The controller (<tt class="docutils literal"><span class="pre">index.php</span></tt>) is now very simple:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="k">require_once</span> <span class="s1">'model.php'</span><span class="p">;</span>

<span class="nv">$posts</span> <span class="o">=</span> <span class="nx">get_all_posts</span><span class="p">();</span>

<span class="k">require</span> <span class="s1">'templates/list.php'</span><span class="p">;</span>
	    </pre></div>
	  </div>
	  <p>Now, the sole task of the controller is to get data from the model layer of
	    the application (the model) and to call a template to render that data.
	    This is a very simple example of the model-view-controller pattern.</p>
	</div>
	<div class="section" id="isolating-the-layout">
	  <h3>Isolating the Layout<a class="headerlink" href="#isolating-the-layout" title="Permalink to this headline">¶</a></h3>
	  <p>At this point, the application has been refactored into three distinct pieces
	    offering various advantages and the opportunity to reuse almost everything
	    on different pages.</p>
	  <p>The only part of the code that <em>can't</em> be reused is the page layout. Fix
	    that by creating a new <tt class="docutils literal"><span class="pre">layout.php</span></tt> file:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- templates/layout.php --&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$title</span> <span class="cp">?&gt;</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$content</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	    </pre></div>
	  </div>
	  <p>The template (<tt class="docutils literal"><span class="pre">templates/list.php</span></tt>) can now be simplified to "extend"
	    the layout:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="nv">$title</span> <span class="o">=</span> <span class="s1">'List of Posts'</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="nb">ob_start</span><span class="p">()</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;h1&gt;</span>List of Posts<span class="nt">&lt;/h1&gt;</span>
    <span class="nt">&lt;ul&gt;</span>
        <span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$posts</span> <span class="k">as</span> <span class="nv">$post</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
        <span class="nt">&lt;li&gt;</span>
            <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"/read?id=</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'id'</span><span class="p">]</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;</span>
                <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'title'</span><span class="p">]</span> <span class="cp">?&gt;</span>
            <span class="nt">&lt;/a&gt;</span>
        <span class="nt">&lt;/li&gt;</span>
        <span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;/ul&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$content</span> <span class="o">=</span> <span class="nb">ob_get_clean</span><span class="p">()</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="k">include</span> <span class="s1">'layout.php'</span> <span class="cp">?&gt;</span>
	    </pre></div>
	  </div>
	  <p>You've now introduced a methodology that allows for the reuse of the
	    layout. Unfortunately, to accomplish this, you're forced to use a few ugly
	    PHP functions (<tt class="docutils literal"><span class="pre">ob_start()</span></tt>, <tt class="docutils literal"><span class="pre">ob_get_clean()</span></tt>) in the template. Symfony2
	    uses a <tt class="docutils literal"><span class="pre">Templating</span></tt> component that allows this to be accomplished cleanly
	    and easily. You'll see it in action shortly.</p>
	</div>
      </div>
      <div class="section" id="adding-a-blog-show-page">
	<h2>Adding a Blog "show" Page<a class="headerlink" href="#adding-a-blog-show-page" title="Permalink to this headline">¶</a></h2>
	<p>The blog "list" page has now been refactored so that the code is better-organized
	  and reusable. To prove it, add a blog "show" page, which displays an individual
	  blog post identified by an <tt class="docutils literal"><span class="pre">id</span></tt> query parameter.</p>
	<p>To begin, create a new function in the <tt class="docutils literal"><span class="pre">model.php</span></tt> file that retrieves
	  an individual blog result based on a given id:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// model.php</span>
<span class="k">function</span> <span class="nf">get_post_by_id</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$link</span> <span class="o">=</span> <span class="nx">open_database_connection</span><span class="p">();</span>

    <span class="nv">$id</span> <span class="o">=</span> <span class="nb">mysql_real_escape_string</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>
    <span class="nv">$query</span> <span class="o">=</span> <span class="s1">'SELECT date, title, body FROM post WHERE id = '</span><span class="o">.</span><span class="nv">$id</span><span class="p">;</span>
    <span class="nv">$result</span> <span class="o">=</span> <span class="nb">mysql_query</span><span class="p">(</span><span class="nv">$query</span><span class="p">);</span>
    <span class="nv">$row</span> <span class="o">=</span> <span class="nb">mysql_fetch_assoc</span><span class="p">(</span><span class="nv">$result</span><span class="p">);</span>

    <span class="nx">close_database_connection</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>

    <span class="k">return</span> <span class="nv">$row</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Next, create a new file called <tt class="docutils literal"><span class="pre">show.php</span></tt> - the controller for this new
	  page:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="k">require_once</span> <span class="s1">'model.php'</span><span class="p">;</span>

<span class="nv">$post</span> <span class="o">=</span> <span class="nx">get_post_by_id</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">'id'</span><span class="p">]);</span>

<span class="k">require</span> <span class="s1">'templates/show.php'</span><span class="p">;</span>
	  </pre></div>
	</div>
	<p>Finally, create the new template file - <tt class="docutils literal"><span class="pre">templates/show.php</span></tt> - to render
	  the individual blog post:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="nv">$title</span> <span class="o">=</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'title'</span><span class="p">]</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="nb">ob_start</span><span class="p">()</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;h1&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'title'</span><span class="p">]</span> <span class="cp">?&gt;</span><span class="nt">&lt;/h1&gt;</span>

    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"date"</span><span class="nt">&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'date'</span><span class="p">]</span> <span class="cp">?&gt;</span><span class="nt">&lt;/div&gt;</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"body"</span><span class="nt">&gt;</span>
        <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="p">[</span><span class="s1">'body'</span><span class="p">]</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$content</span> <span class="o">=</span> <span class="nb">ob_get_clean</span><span class="p">()</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="k">include</span> <span class="s1">'layout.php'</span> <span class="cp">?&gt;</span>
	  </pre></div>
	</div>
	<p>Creating the second page is now very easy and no code is duplicated. Still,
	  this page introduces even more lingering problems that a framework can solve
	  for you. For example, a missing or invalid <tt class="docutils literal"><span class="pre">id</span></tt> query parameter will cause
	  the page to crash. It would be better if this caused a 404 page to be rendered,
	  but this can't really be done easily yet. Worse, had you forgotten to clean
	  the <tt class="docutils literal"><span class="pre">id</span></tt> parameter via the <tt class="docutils literal"><span class="pre">mysql_real_escape_string()</span></tt> function, your
	  entire database would be at risk for an SQL injection attack.</p>
	<p>Another major problem is that each individual controller file must include
	  the <tt class="docutils literal"><span class="pre">model.php</span></tt> file. What if each controller file suddenly needed to include
	  an additional file or perform some other global task (e.g. enforce security)?
	  As it stands now, that code would need to be added to every controller file.
	  If you forget to include something in one file, hopefully it doesn't relate
	  to security...</p>
      </div>
      <div class="section" id="a-front-controller-to-the-rescue">
	<h2>A "Front Controller" to the Rescue<a class="headerlink" href="#a-front-controller-to-the-rescue" title="Permalink to this headline">¶</a></h2>
	<p>The solution is to use a <a class="reference internal" href="../glossary.html#term-front-controller"><em class="xref std std-term">front controller</em></a>: a single PHP file through
	  which <em>all</em> requests are processed. With a front controller, the URIs for the
	  application change slightly, but start to become more flexible:</p>
	<div class="highlight-text"><div class="highlight"><pre>Without a front controller
/index.php          =&gt; Blog post list page (index.php executed)
/show.php           =&gt; Blog post show page (show.php executed)

With index.php as the front controller
/index.php          =&gt; Blog post list page (index.php executed)
/index.php/show     =&gt; Blog post show page (index.php executed)
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">index.php</span></tt> portion of the URI can be removed if using Apache
	      rewrite rules (or equivalent). In that case, the resulting URI of the
	      blog show page would be simply <tt class="docutils literal"><span class="pre">/show</span></tt>.</p>
	</div></div>
	<p>When using a front controller, a single PHP file (<tt class="docutils literal"><span class="pre">index.php</span></tt> in this case)
	  renders <em>every</em> request. For the blog post show page, <tt class="docutils literal"><span class="pre">/index.php/show</span></tt> will
	  actually execute the <tt class="docutils literal"><span class="pre">index.php</span></tt> file, which is now responsible for routing
	  requests internally based on the full URI. As you'll see, a front controller
	  is a very powerful tool.</p>
	<div class="section" id="creating-the-front-controller">
	  <h3>Creating the Front Controller<a class="headerlink" href="#creating-the-front-controller" title="Permalink to this headline">¶</a></h3>
	  <p>You're about to take a <strong>big</strong> step with the application. With one file handling
	    all requests, you can centralize things such as security handling, configuration
	    loading, and routing. In this application, <tt class="docutils literal"><span class="pre">index.php</span></tt> must now be smart
	    enough to render the blog post list page <em>or</em> the blog post show page based
	    on the requested URI:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// index.php</span>

<span class="c1">// load and initialize any global libraries</span>
<span class="k">require_once</span> <span class="s1">'model.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="s1">'controllers.php'</span><span class="p">;</span>

<span class="c1">// route the request internally</span>
<span class="nv">$uri</span> <span class="o">=</span> <span class="nv">$_SERVER</span><span class="p">[</span><span class="s1">'REQUEST_URI'</span><span class="p">];</span>
<span class="k">if</span> <span class="p">(</span><span class="nv">$uri</span> <span class="o">==</span> <span class="s1">'/index.php'</span><span class="p">)</span> <span class="p">{</span>
    <span class="nx">list_action</span><span class="p">();</span>
<span class="p">}</span> <span class="k">elseif</span> <span class="p">(</span><span class="nv">$uri</span> <span class="o">==</span> <span class="s1">'/index.php/show'</span> <span class="o">&amp;&amp;</span> <span class="nb">isset</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">'id'</span><span class="p">]))</span> <span class="p">{</span>
    <span class="nx">show_action</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">'id'</span><span class="p">]);</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="nb">header</span><span class="p">(</span><span class="s1">'Status: 404 Not Found'</span><span class="p">);</span>
    <span class="k">echo</span> <span class="s1">'&lt;html&gt;&lt;body&gt;&lt;h1&gt;Page Not Found&lt;/h1&gt;&lt;/body&gt;&lt;/html&gt;'</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>For organization, both controllers (formerly <tt class="docutils literal"><span class="pre">index.php</span></tt> and <tt class="docutils literal"><span class="pre">show.php</span></tt>)
	    are now PHP functions and each has been moved into a separate file, <tt class="docutils literal"><span class="pre">controllers.php</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">function</span> <span class="nf">list_action</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$posts</span> <span class="o">=</span> <span class="nx">get_all_posts</span><span class="p">();</span>
    <span class="k">require</span> <span class="s1">'templates/list.php'</span><span class="p">;</span>
<span class="p">}</span>

<span class="k">function</span> <span class="nf">show_action</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$post</span> <span class="o">=</span> <span class="nx">get_post_by_id</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>
    <span class="k">require</span> <span class="s1">'templates/show.php'</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>As a front controller, <tt class="docutils literal"><span class="pre">index.php</span></tt> has taken on an entirely new role, one
	    that includes loading the core libraries and routing the application so that
	    one of the two controllers (the <tt class="docutils literal"><span class="pre">list_action()</span></tt> and <tt class="docutils literal"><span class="pre">show_action()</span></tt>
	    functions) is called. In reality, the front controller is beginning to look and
	    act a lot like Symfony2's mechanism for handling and routing requests.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Another advantage of a front controller is flexible URLs. Notice that
		the URL to the blog post show page could be changed from <tt class="docutils literal"><span class="pre">/show</span></tt> to <tt class="docutils literal"><span class="pre">/read</span></tt>
		by changing code in only one location. Before, an entire file needed to
		be renamed. In Symfony2, URLs are even more flexible.</p>
	  </div></div>
	  <p>By now, the application has evolved from a single PHP file into a structure
	    that is organized and allows for code reuse. You should be happier, but far
	    from satisfied. For example, the "routing" system is fickle, and wouldn't
	    recognize that the list page (<tt class="docutils literal"><span class="pre">/index.php</span></tt>) should be accessible also via <tt class="docutils literal"><span class="pre">/</span></tt>
	    (if Apache rewrite rules were added). Also, instead of developing the blog,
	    a lot of time is being spent working on the "architecture" of the code (e.g.
	    routing, calling controllers, templates, etc.). More time will need to be
	    spent to handle form submissions, input validation, logging and security.
	    Why should you have to reinvent solutions to all these routine problems?</p>
	</div>
	<div class="section" id="add-a-touch-of-symfony2">
	  <h3>Add a Touch of Symfony2<a class="headerlink" href="#add-a-touch-of-symfony2" title="Permalink to this headline">¶</a></h3>
	  <p>Symfony2 to the rescue. Before actually using Symfony2, you need to make
	    sure PHP knows how to find the Symfony2 classes. This is accomplished via
	    an autoloader that Symfony provides. An autoloader is a tool that makes it
	    possible to start using PHP classes without explicitly including the file
	    containing the class.</p>
	  <p>First, <a class="reference external" href="http://symfony.com/download">download symfony</a> and place it into a <tt class="docutils literal"><span class="pre">vendor/symfony/</span></tt> directory.
	    Next, create an <tt class="docutils literal"><span class="pre">app/bootstrap.php</span></tt> file. Use it to <tt class="docutils literal"><span class="pre">require</span></tt> the two
	    files in the application and to configure the autoloader:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// bootstrap.php</span>
<span class="k">require_once</span> <span class="s1">'model.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="s1">'controllers.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="s1">'vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php'</span><span class="p">;</span>

<span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Symfony\Component\ClassLoader\UniversalClassLoader</span><span class="p">();</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Symfony'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/symfony/src'</span><span class="p">,</span>
<span class="p">));</span>

<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">register</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>This tells the autoloader where the <tt class="docutils literal"><span class="pre">Symfony</span></tt> classes are. With this, you
	    can start using Symfony classes without using the <tt class="docutils literal"><span class="pre">require</span></tt> statement for
	    the files that contain them.</p>
	  <p>Core to Symfony's philosophy is the idea that an application's main job is
	    to interpret each request and return a response. To this end, Symfony2 provides
	    both a <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html" title="Symfony\Component\HttpFoundation\Request"><span class="pre">Request</span></a></tt> and a
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Response.html" title="Symfony\Component\HttpFoundation\Response"><span class="pre">Response</span></a></tt> class. These classes are
	    object-oriented representations of the raw HTTP request being processed and
	    the HTTP response being returned. Use them to improve the blog:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// index.php</span>
<span class="k">require_once</span> <span class="s1">'app/bootstrap.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="nv">$request</span> <span class="o">=</span> <span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">();</span>

<span class="nv">$uri</span> <span class="o">=</span> <span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getPathInfo</span><span class="p">();</span>
<span class="k">if</span> <span class="p">(</span><span class="nv">$uri</span> <span class="o">==</span> <span class="s1">'/'</span><span class="p">)</span> <span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="nx">list_action</span><span class="p">();</span>
<span class="p">}</span> <span class="k">elseif</span> <span class="p">(</span><span class="nv">$uri</span> <span class="o">==</span> <span class="s1">'/show'</span> <span class="o">&amp;&amp;</span> <span class="nv">$request</span><span class="o">-&gt;</span><span class="na">query</span><span class="o">-&gt;</span><span class="na">has</span><span class="p">(</span><span class="s1">'id'</span><span class="p">))</span> <span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="nx">show_action</span><span class="p">(</span><span class="nv">$request</span><span class="o">-&gt;</span><span class="na">query</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'id'</span><span class="p">));</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="nv">$html</span> <span class="o">=</span> <span class="s1">'&lt;html&gt;&lt;body&gt;&lt;h1&gt;Page Not Found&lt;/h1&gt;&lt;/body&gt;&lt;/html&gt;'</span><span class="p">;</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$html</span><span class="p">,</span> <span class="mi">404</span><span class="p">);</span>
<span class="p">}</span>

<span class="c1">// echo the headers and send the response</span>
<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>The controllers are now responsible for returning a <tt class="docutils literal"><span class="pre">Response</span></tt> object.
	    To make this easier, you can add a new <tt class="docutils literal"><span class="pre">render_template()</span></tt> function, which,
	    incidentally, acts quite a bit like the Symfony2 templating engine:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// controllers.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="k">function</span> <span class="nf">list_action</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$posts</span> <span class="o">=</span> <span class="nx">get_all_posts</span><span class="p">();</span>
    <span class="nv">$html</span> <span class="o">=</span> <span class="nx">render_template</span><span class="p">(</span><span class="s1">'templates/list.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'posts'</span> <span class="o">=&gt;</span> <span class="nv">$posts</span><span class="p">));</span>

    <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$html</span><span class="p">);</span>
<span class="p">}</span>

<span class="k">function</span> <span class="nf">show_action</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$post</span> <span class="o">=</span> <span class="nx">get_post_by_id</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>
    <span class="nv">$html</span> <span class="o">=</span> <span class="nx">render_template</span><span class="p">(</span><span class="s1">'templates/show.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'post'</span> <span class="o">=&gt;</span> <span class="nv">$post</span><span class="p">));</span>

    <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$html</span><span class="p">);</span>
<span class="p">}</span>

<span class="c1">// helper function to render templates</span>
<span class="k">function</span> <span class="nf">render_template</span><span class="p">(</span><span class="nv">$path</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$args</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nb">extract</span><span class="p">(</span><span class="nv">$args</span><span class="p">);</span>
    <span class="nb">ob_start</span><span class="p">();</span>
    <span class="k">require</span> <span class="nv">$path</span><span class="p">;</span>
    <span class="nv">$html</span> <span class="o">=</span> <span class="nb">ob_get_clean</span><span class="p">();</span>

    <span class="k">return</span> <span class="nv">$html</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>By bringing in a small part of Symfony2, the application is more flexible and
	    reliable. The <tt class="docutils literal"><span class="pre">Request</span></tt> provides a dependable way to access information
	    about the HTTP request. Specifically, the <tt class="docutils literal"><span class="pre">getPathInfo()</span></tt> method returns
	    a cleaned URI (always returning <tt class="docutils literal"><span class="pre">/show</span></tt> and never <tt class="docutils literal"><span class="pre">/index.php/show</span></tt>).
	    So, even if the user goes to <tt class="docutils literal"><span class="pre">/index.php/show</span></tt>, the application is intelligent
	    enough to route the request through <tt class="docutils literal"><span class="pre">show_action()</span></tt>.</p>
	  <p>The <tt class="docutils literal"><span class="pre">Response</span></tt> object gives flexibility when constructing the HTTP response,
	    allowing HTTP headers and content to be added via an object-oriented interface.
	    And while the responses in this application are simple, this flexibility
	    will pay dividends as your application grows.</p>
	</div>
	<div class="section" id="the-sample-application-in-symfony2">
	  <h3>The Sample Application in Symfony2<a class="headerlink" href="#the-sample-application-in-symfony2" title="Permalink to this headline">¶</a></h3>
	  <p>The blog has come a <em>long</em> way, but it still contains a lot of code for such
	    a simple application. Along the way, we've also invented a simple routing
	    system and a method using <tt class="docutils literal"><span class="pre">ob_start()</span></tt> and <tt class="docutils literal"><span class="pre">ob_get_clean()</span></tt> to render
	    templates. If, for some reason, you needed to continue building this "framework"
	    from scratch, you could at least use Symfony's standalone <a class="reference external" href="https://github.com/symfony/Routing">Routing</a> and
	    <a class="reference external" href="https://github.com/symfony/Templating">Templating</a> components, which already solve these problems.</p>
	  <p>Instead of re-solving common problems, you can let Symfony2 take care of
	    them for you. Here's the same sample application, now built in Symfony2:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// src/Acme/BlogBundle/Controller/BlogController.php</span>

<span class="k">namespace</span> <span class="nx">Acme\BlogBundle\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">BlogController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">listAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$posts</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
            <span class="o">-&gt;</span><span class="na">createQuery</span><span class="p">(</span><span class="s1">'SELECT p FROM AcmeBlogBundle:Post p'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Post:list.html.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'posts'</span> <span class="o">=&gt;</span> <span class="nv">$posts</span><span class="p">));</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$post</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">()</span>
            <span class="o">-&gt;</span><span class="na">getRepository</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Post'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="nv">$id</span><span class="p">);</span>

        <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$post</span><span class="p">)</span> <span class="p">{</span>
            <span class="c1">// cause the 404 page not found to be displayed</span>
            <span class="k">throw</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createNotFoundException</span><span class="p">();</span>
        <span class="p">}</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Post:show.html.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'post'</span> <span class="o">=&gt;</span> <span class="nv">$post</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The two controllers are still lightweight. Each uses the Doctrine ORM library
	    to retrieve objects from the database and the <tt class="docutils literal"><span class="pre">Templating</span></tt> component to
	    render a template and return a <tt class="docutils literal"><span class="pre">Response</span></tt> object. The list template is
	    now quite a bit simpler:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/BlogBundle/Resources/views/Blog/list.html.php --&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'::layout.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'List of Posts'</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="nt">&lt;h1&gt;</span>List of Posts<span class="nt">&lt;/h1&gt;</span>
<span class="nt">&lt;ul&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$posts</span> <span class="k">as</span> <span class="nv">$post</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;li&gt;</span>
        <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'router'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'id'</span> <span class="o">=&gt;</span> <span class="nv">$post</span><span class="o">-&gt;</span><span class="na">getId</span><span class="p">()))</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;</span>
            <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$post</span><span class="o">-&gt;</span><span class="na">getTitle</span><span class="p">()</span> <span class="cp">?&gt;</span>
        <span class="nt">&lt;/a&gt;</span>
    <span class="nt">&lt;/li&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/ul&gt;</span>
	    </pre></div>
	  </div>
	  <p>The layout is nearly identical:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- app/Resources/views/layout.html.php --&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'Default title'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'_content'</span><span class="p">)</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">We'll leave the show template as an exercise, as it should be trivial to
		create based on the list template.</p>
	  </div></div>
	  <p>When Symfony2's engine (called the <tt class="docutils literal"><span class="pre">Kernel</span></tt>) boots up, it needs a map so
	    that it knows which controllers to execute based on the request information.
	    A routing configuration map provides this information in a readable format:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="nx">blog_list</span><span class="o">:</span>
    <span class="nx">pattern</span><span class="o">:</span>  <span class="o">/</span><span class="nx">blog</span>
    <span class="nx">defaults</span><span class="o">:</span> <span class="p">{</span> <span class="nx">_controller</span><span class="o">:</span> <span class="nx">AcmeBlogBundle</span><span class="o">:</span><span class="nx">Blog</span><span class="o">:</span><span class="k">list</span> <span class="p">}</span>

<span class="nx">blog_show</span><span class="o">:</span>
    <span class="nx">pattern</span><span class="o">:</span>  <span class="o">/</span><span class="nx">blog</span><span class="o">/</span><span class="nx">show</span><span class="o">/</span><span class="p">{</span><span class="nx">id</span><span class="p">}</span>
    <span class="nx">defaults</span><span class="o">:</span> <span class="p">{</span> <span class="nx">_controller</span><span class="o">:</span> <span class="nx">AcmeBlogBundle</span><span class="o">:</span><span class="nx">Blog</span><span class="o">:</span><span class="nx">show</span> <span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Now that Symfony2 is handling all the mundane tasks, the front controller
	    is dead simple. And since it does so little, you'll never have to touch
	    it once it's created (and if you use a Symfony2 distribution, you won't
	    even need to create it!):</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span>
<span class="c1">// web/app.php</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/bootstrap.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppKernel.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'prod'</span><span class="p">,</span> <span class="k">false</span><span class="p">);</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>The front controller's only job is to initialize Symfony2's engine (<tt class="docutils literal"><span class="pre">Kernel</span></tt>)
	    and pass it a <tt class="docutils literal"><span class="pre">Request</span></tt> object to handle. Symfony2's core then uses the
	    routing map to determine which controller to call. Just like before, the
	    controller method is responsible for returning the final <tt class="docutils literal"><span class="pre">Response</span></tt> object.
	    There's really not much else to it.</p>
	  <p>For a visual representation of how Symfony2 handles each request, see the
	    <a class="reference internal" href="http_fundamentals.html#request-flow-figure"><em>request flow diagram</em></a>.</p>
	</div>
	<div class="section" id="where-symfony2-delivers">
	  <h3>Where Symfony2 Delivers<a class="headerlink" href="#where-symfony2-delivers" title="Permalink to this headline">¶</a></h3>
	  <p>In the upcoming chapters, you'll learn more about how each piece of Symfony
	    works and the recommended organization of a project. For now, let's see how
	    migrating the blog from flat PHP to Symfony2 has improved life:</p>
	  <ul class="simple">
	    <li>Your application now has <strong>clear and consistently organized code</strong> (though
	      Symfony doesn't force you into this). This promotes <strong>reusability</strong> and
	      allows for new developers to be productive in your project more quickly.</li>
	    <li>100% of the code you write is for <em>your</em> application. You <strong>don't need
		to develop or maintain low-level utilities</strong> such as <a class="reference internal" href="page_creation.html#autoloading-introduction-sidebar"><em>autoloading</em></a>,
	      <a class="reference internal" href="routing.html"><em>routing</em></a>, or rendering <a class="reference internal" href="controller.html"><em>controllers</em></a>.</li>
	    <li>Symfony2 gives you <strong>access to open source tools</strong> such as Doctrine and the
	      Templating, Security, Form, Validation and Translation components (to name
	      a few).</li>
	    <li>The application now enjoys <strong>fully-flexible URLs</strong> thanks to the <tt class="docutils literal"><span class="pre">Routing</span></tt>
	      component.</li>
	    <li>Symfony2's HTTP-centric architecture gives you access to powerful tools
	      such as <strong>HTTP caching</strong> powered by <strong>Symfony2's internal HTTP cache</strong> or
	      more powerful tools such as <a class="reference external" href="http://www.varnish-cache.org">Varnish</a>. This is covered in a later chapter
	      all about <a class="reference internal" href="http_cache.html"><em>caching</em></a>.</li>
	  </ul>
	  <p>And perhaps best of all, by using Symfony2, you now have access to a whole
	    set of <strong>high-quality open source tools developed by the Symfony2 community</strong>!
	    For more information, check out <a class="reference external" href="http://symfony2bundles.org">Symfony2Bundles.org</a></p>
	</div>
      </div>
      <div class="section" id="better-templates">
	<h2>Better templates<a class="headerlink" href="#better-templates" title="Permalink to this headline">¶</a></h2>
	<p>If you choose to use it, Symfony2 comes standard with a templating engine
	  called <a class="reference external" href="http://www.twig-project.org">Twig</a> that makes templates faster to write and easier to read.
	  It means that the sample application could contain even less code! Take,
	  for example, the list template written in Twig:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# src/Acme/BlogBundle/Resources/views/Blog/list.html.twig #}</span>

<span class="cp">{%</span> <span class="k">extends</span> <span class="s2">"::layout.html.twig"</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="cp">%}</span>List of Posts<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}</span>
    <span class="nt">&lt;h1&gt;</span>List of Posts<span class="nt">&lt;/h1&gt;</span>
    <span class="nt">&lt;ul&gt;</span>
        <span class="cp">{%</span> <span class="k">for</span> <span class="nv">post</span> <span class="k">in</span> <span class="nv">posts</span> <span class="cp">%}</span>
        <span class="nt">&lt;li&gt;</span>
            <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'blog_show'</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'id'</span><span class="o">:</span> <span class="nv">post.id</span> <span class="o">})</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
                <span class="cp">{{</span> <span class="nv">post.title</span> <span class="cp">}}</span>
            <span class="nt">&lt;/a&gt;</span>
        <span class="nt">&lt;/li&gt;</span>
        <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
    <span class="nt">&lt;/ul&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	  </pre></div>
	</div>
	<p>The corresponding <tt class="docutils literal"><span class="pre">layout.html.twig</span></tt> template is also easier to write:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# app/Resources/views/layout.html.twig #}</span>

<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span><span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="cp">%}</span>Default title<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	  </pre></div>
	</div>
	<p>Twig is well-supported in Symfony2. And while PHP templates will always
	  be supported in Symfony2, we'll continue to discuss the many advantages of
	  Twig. For more information, see the <a class="reference internal" href="templating.html"><em>templating chapter</em></a>.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/templating/PHP.html"><em>How to use PHP instead of Twig for Templates</em></a></li>
	  <li><a class="reference internal" href="../cookbook/controller/service.html"><em>How to define Controllers as Services</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Symfony2 and HTTP Fundamentals" href="http_fundamentals.html">
      «&nbsp;Основы Symfony2 и HTTP
    </a><span class="separator">|</span>
    <a accesskey="N" title="Installing and Configuring Symfony" href="installation.html">
      Установка и настройка Symfony&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
