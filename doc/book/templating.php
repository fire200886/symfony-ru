<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">Creating and using Templates</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="creating-and-using-templates">
      <span id="index-0"></span><h1>Creating and using Templates<a class="headerlink" href="#creating-and-using-templates" title="Permalink to this headline">¶</a></h1>
      <p>As you know, the <a class="reference internal" href="controller.html"><em>controller</em></a> is responsible for
	handling each request that comes into a Symfony2 application. In reality,
	the controller delegates the most of the heavy work to other places so that
	code can be tested and reused. When a controller needs to generate HTML,
	CSS or any other content, it hands the work off to the templating engine.
	In this chapter, you'll learn how to write powerful templates that can be
	used to return content to the user, populate email bodies, and more. You'll
	learn shortcuts, clever ways to extend templates and how to reuse template
	code.</p>
      <div class="section" id="templates">
	<span id="index-1"></span><h2>Templates<a class="headerlink" href="#templates" title="Permalink to this headline">¶</a></h2>
	<p>A template is simply a text file that can generate any text-based format
	  (HTML, XML, CSV, LaTeX ...). The most familiar type of template is a <em>PHP</em>
	  template - a text file parsed by PHP that contains a mix of text and PHP code:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;!</span><span class="nx">DOCTYPE</span> <span class="nx">html</span><span class="o">&gt;</span>
<span class="o">&lt;</span><span class="nx">html</span><span class="o">&gt;</span>
    <span class="o">&lt;</span><span class="nx">head</span><span class="o">&gt;</span>
        <span class="o">&lt;</span><span class="nx">title</span><span class="o">&gt;</span><span class="nx">Welcome</span> <span class="nx">to</span> <span class="nx">Symfony</span><span class="o">!&lt;/</span><span class="nx">title</span><span class="o">&gt;</span>
    <span class="o">&lt;/</span><span class="nx">head</span><span class="o">&gt;</span>
    <span class="o">&lt;</span><span class="nx">body</span><span class="o">&gt;</span>
        <span class="o">&lt;</span><span class="nx">h1</span><span class="o">&gt;&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$page_title</span> <span class="cp">?&gt;</span><span class="x">&lt;/h1&gt;</span>

<span class="x">        &lt;ul id="navigation"&gt;</span>
<span class="x">            </span><span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$navigation</span> <span class="k">as</span> <span class="nv">$item</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">                &lt;li&gt;</span>
<span class="x">                    &lt;a href="</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$item</span><span class="o">-&gt;</span><span class="na">getHref</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x">"&gt;</span>
<span class="x">                        </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$item</span><span class="o">-&gt;</span><span class="na">getCaption</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">                    &lt;/a&gt;</span>
<span class="x">                &lt;/li&gt;</span>
<span class="x">            </span><span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">        &lt;/ul&gt;</span>
<span class="x">    &lt;/body&gt;</span>
<span class="x">&lt;/html&gt;</span>
	  </pre></div>
	</div>
	<p id="index-2">But Symfony2 packages an even more powerful templating language called <a class="reference external" href="http://www.twig-project.org">Twig</a>
	  Twig allows you to write concise, readable templates that are more friendly
	  to web designers and, in several ways, more powerful than PHP templates:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">&lt;!DOCTYPE html&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span>Welcome to Symfony!<span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="nt">&lt;h1&gt;</span><span class="cp">{{</span> <span class="nv">page_title</span> <span class="cp">}}</span><span class="nt">&lt;/h1&gt;</span>

        <span class="nt">&lt;ul</span> <span class="na">id=</span><span class="s">"navigation"</span><span class="nt">&gt;</span>
            <span class="cp">{%</span> <span class="k">for</span> <span class="nv">item</span> <span class="k">in</span> <span class="nv">navigation</span> <span class="cp">%}</span>
                <span class="nt">&lt;li&gt;&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">item.href</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span><span class="cp">{{</span> <span class="nv">item.caption</span> <span class="cp">}}</span><span class="nt">&lt;/a&gt;&lt;/li&gt;</span>
            <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
        <span class="nt">&lt;/ul&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	  </pre></div>
	</div>
	<p>Twig contains defines two types of special syntax:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">...</span> <span class="pre">}}</span></tt>: "Says something": prints a variable or the result of an
	    expression to the template;</li>
	  <li><tt class="docutils literal"><span class="pre">{%</span> <span class="pre">...</span> <span class="pre">%}</span></tt>: "Does something": a <strong>tag</strong> that controls the logic of the
	    template; it is used to execute statements such as for-loops for example.</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">There is a third syntax used for creating comments: <tt class="docutils literal"><span class="pre">{#</span> <span class="pre">this</span> <span class="pre">is</span> <span class="pre">a</span> <span class="pre">comment</span> <span class="pre">#}</span></tt>.
	      This syntax can be used across multiple lines like the PHP-equivalent
	      <tt class="docutils literal"><span class="pre">/*</span> <span class="pre">comment</span> <span class="pre">*/</span></tt> syntax.</p>
	</div></div>
	<p>Twig also contains <strong>filters</strong>, which modify content before being rendered.
	  The following makes the <tt class="docutils literal"><span class="pre">title</span></tt> variable all uppercase before rendering
	  it:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">title</span> <span class="o">|</span> <span class="nf">upper</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>Twig comes with a long list of <a class="reference external" href="http://www.twig-project.org/doc/templates.html#comments">tags</a> and <a class="reference external" href="http://www.twig-project.org/doc/templates.html#list-of-built-in-filters">filters</a> that are available
	  by default. You can even <a class="reference external" href="http://www.twig-project.org/doc/advanced.html">add your own extensions</a> to Twig as needed.</p>
	<p>As you'll see throughout the documentation, Twig also supports functions
	  and new functions can be easily added. For example, the following uses a
	  standard <tt class="docutils literal"><span class="pre">if</span></tt> tag and the <tt class="docutils literal"><span class="pre">cycle</span></tt> function to print ten div tags, with
	  alternating <tt class="docutils literal"><span class="pre">odd</span></tt>, <tt class="docutils literal"><span class="pre">even</span></tt> classes:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">for</span> <span class="nv">i</span> <span class="k">in</span> <span class="m">0.</span><span class="nv">.10</span> <span class="cp">%}</span>
  <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">cycle</span><span class="o">([</span><span class="s1">'odd'</span><span class="o">,</span> <span class="s1">'even'</span><span class="o">],</span> <span class="nv">i</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
    <span class="c">&lt;!-- some HTML here --&gt;</span>
  <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
	  </pre></div>
	</div>
	<p>Throughout this chapter, template examples will be shown in both Twig and PHP.</p>
	<div class="admonition-wrapper">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Why Twig?</p>
	    <p>Twig templates are meant to be simple and won't process PHP tags. This
	      is by design: the Twig template system is meant to express presentation,
	      not program logic. The more you use Twig, the more you'll appreciate
	      and benefit from this distinction. And of course, you'll be loved by
	      web designers everywhere.</p>
	    <p>Twig can also do things that PHP can't, such as true template inheritance
	      (Twig templates compile down to PHP classes that inherit from each other),
	      whitespace control, sandboxing, and the inclusion of custom functions
	      and filters that only affect templates. Twig contains little features
	      that make writing templates easier and more concise. Take the following
	      example, which combines a loop with a logical <tt class="docutils literal"><span class="pre">if</span></tt> statement:</p>
	    <div class="last highlight-html+jinja"><div class="highlight"><pre><span class="nt">&lt;ul&gt;</span>
    <span class="cp">{%</span> <span class="k">for</span> <span class="nv">user</span> <span class="k">in</span> <span class="nv">users</span> <span class="cp">%}</span>
        <span class="nt">&lt;li&gt;</span><span class="cp">{{</span> <span class="nv">user.username</span> <span class="cp">}}</span><span class="nt">&lt;/li&gt;</span>
    <span class="cp">{%</span> <span class="k">else</span> <span class="cp">%}</span>
        <span class="nt">&lt;li&gt;</span>No users found<span class="nt">&lt;/li&gt;</span>
    <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
<span class="nt">&lt;/ul&gt;</span>
	      </pre></div>
	    </div>
	</div></div>
	<div class="section" id="twig-template-caching">
	  <span id="index-3"></span><h3>Twig Template Caching<a class="headerlink" href="#twig-template-caching" title="Permalink to this headline">¶</a></h3>
	  <p>Twig is fast. Each Twig template is compiled down to a native PHP class
	    that is rendered at runtime. The compiled classes are located in the
	    <tt class="docutils literal"><span class="pre">app/cache/{environment}/twig</span></tt> directory (where <tt class="docutils literal"><span class="pre">{environment}</span></tt> is the
	    environment, such as <tt class="docutils literal"><span class="pre">dev</span></tt> or <tt class="docutils literal"><span class="pre">prod</span></tt>) and in some cases can be useful
	    while debugging. See <a class="reference internal" href="page_creation.html#environments-summary"><em>Environments</em></a> for more information on
	    environments.</p>
	  <p>When <tt class="docutils literal"><span class="pre">debug</span></tt> mode is enabled (common in the <tt class="docutils literal"><span class="pre">dev</span></tt> environment) a Twig
	    template will be automatically recompiled when changes are made to it. This
	    means that during development you can happily make changes to a Twig template
	    and instantly see the changes without needing to worry about clearing any
	    cache.</p>
	  <p>When <tt class="docutils literal"><span class="pre">debug</span></tt> mode is disabled (common in the <tt class="docutils literal"><span class="pre">prod</span></tt> environment), however,
	    you must clear the Twig cache directory so that the Twig templates will
	    regenerate. Remember to do this when deploying your application.</p>
	</div>
      </div>
      <div class="section" id="template-inheritance-and-layouts">
	<span id="index-4"></span><h2>Template Inheritance and Layouts<a class="headerlink" href="#template-inheritance-and-layouts" title="Permalink to this headline">¶</a></h2>
	<p>More often than not, templates in a project share common elements, like the
	  header, footer, sidebar or more. In Symfony2, we like to think about this
	  problem differently: a template can be decorated by another one. This works
	  exactly the same as PHP classes: template inheritance allows you to build
	  a base "layout" template that contains all the common elements of your site
	  defined as <strong>blocks</strong> (think "PHP class with base methods"). A child template
	  can extend the base layout and override any of its blocks (think "PHP subclass
	  that overrides certain methods of its parent class").</p>
	<p>First, build a base layout file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 454px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# app/Resources/views/base.html.twig #}</span>
<span class="cp">&lt;!DOCTYPE html&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;meta</span> <span class="na">http-equiv=</span><span class="s">"Content-Type"</span> <span class="na">content=</span><span class="s">"text/html; charset=utf-8"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;title&gt;</span><span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="cp">%}</span>Test Application<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="nt">&lt;div</span> <span class="na">id=</span><span class="s">"sidebar"</span><span class="nt">&gt;</span>
            <span class="cp">{%</span> <span class="k">block</span> <span class="nv">sidebar</span> <span class="cp">%}</span>
            <span class="nt">&lt;ul&gt;</span>
                <span class="nt">&lt;li&gt;&lt;a</span> <span class="na">href=</span><span class="s">"/"</span><span class="nt">&gt;</span>Home<span class="nt">&lt;/a&gt;&lt;/li&gt;</span>
                <span class="nt">&lt;li&gt;&lt;a</span> <span class="na">href=</span><span class="s">"/blog"</span><span class="nt">&gt;</span>Blog<span class="nt">&lt;/a&gt;&lt;/li&gt;</span>
            <span class="nt">&lt;/ul&gt;</span>
            <span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
        <span class="nt">&lt;/div&gt;</span>

        <span class="nt">&lt;div</span> <span class="na">id=</span><span class="s">"content"</span><span class="nt">&gt;</span>
            <span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
        <span class="nt">&lt;/div&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">app</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">base</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;!</span><span class="nx">DOCTYPE</span> <span class="nx">html</span><span class="o">&gt;</span>
<span class="o">&lt;</span><span class="nx">html</span><span class="o">&gt;</span>
    <span class="o">&lt;</span><span class="nx">head</span><span class="o">&gt;</span>
        <span class="o">&lt;</span><span class="nx">meta</span> <span class="nx">http</span><span class="o">-</span><span class="nx">equiv</span><span class="o">=</span><span class="s2">"Content-Type"</span> <span class="nx">content</span><span class="o">=</span><span class="s2">"text/html; charset=utf-8"</span> <span class="o">/&gt;</span>
        <span class="o">&lt;</span><span class="nx">title</span><span class="o">&gt;&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'Test Application'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x">&lt;/title&gt;</span>
<span class="x">    &lt;/head&gt;</span>
<span class="x">    &lt;body&gt;</span>
<span class="x">        &lt;div id="sidebar"&gt;</span>
<span class="x">            </span><span class="cp">&lt;?php</span> <span class="k">if</span> <span class="p">(</span><span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">has</span><span class="p">(</span><span class="s1">'sidebar'</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">                </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'sidebar'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">            </span><span class="cp">&lt;?php</span> <span class="k">else</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">                &lt;ul&gt;</span>
<span class="x">                    &lt;li&gt;&lt;a href="/"&gt;Home&lt;/a&gt;&lt;/li&gt;</span>
<span class="x">                    &lt;li&gt;&lt;a href="/blog"&gt;Blog&lt;/a&gt;&lt;/li&gt;</span>
<span class="x">                &lt;/ul&gt;</span>
<span class="x">            </span><span class="cp">&lt;?php</span> <span class="k">endif</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">        &lt;/div&gt;</span>

<span class="x">        &lt;div id="content"&gt;</span>
<span class="x">            </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'body'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">        &lt;/div&gt;</span>
<span class="x">    &lt;/body&gt;</span>
<span class="x">&lt;/html&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Though the discussion about template inheritance will be in terms of Twig,
	      the philosophy is the same between Twig and PHP templates.</p>
	</div></div>
	<p>This template defines the base HTML skeleton document of a simple two-column
	  page. In this example, three <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt> areas are defined (<tt class="docutils literal"><span class="pre">title</span></tt>,
	  <tt class="docutils literal"><span class="pre">sidebar</span></tt> and <tt class="docutils literal"><span class="pre">body</span></tt>). Each block may be overridden by a child template
	  or left with its default implementation. This template could also be rendered
	  directly. In that case the <tt class="docutils literal"><span class="pre">title</span></tt>, <tt class="docutils literal"><span class="pre">sidebar</span></tt> and <tt class="docutils literal"><span class="pre">body</span></tt> blocks would
	  simply retain the default values used in this template.</p>
	<p>A child template might look like this:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 256px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/BlogBundle/Resources/views/Blog/index.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'::base.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="cp">%}</span>My cool blog posts<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}</span>
    <span class="cp">{%</span> <span class="k">for</span> <span class="nv">entry</span> <span class="k">in</span> <span class="nv">blog_entries</span> <span class="cp">%}</span>
        <span class="nt">&lt;h2&gt;</span><span class="cp">{{</span> <span class="nv">entry.title</span> <span class="cp">}}</span><span class="nt">&lt;/h2&gt;</span>
        <span class="nt">&lt;p&gt;</span><span class="cp">{{</span> <span class="nv">entry.body</span> <span class="cp">}}</span><span class="nt">&lt;/p&gt;</span>
    <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">src</span><span class="o">/</span><span class="nx">Acme</span><span class="o">/</span><span class="nx">BlogBundle</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">Blog</span><span class="o">/</span><span class="nx">index</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;?</span><span class="nx">php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'::base.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>

<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'My cool blog posts'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>

<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">start</span><span class="p">(</span><span class="s1">'body'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$blog_entries</span> <span class="k">as</span> <span class="nv">$entry</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">        &lt;h2&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$entry</span><span class="o">-&gt;</span><span class="na">getTitle</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x">&lt;/h2&gt;</span>
<span class="x">        &lt;p&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$entry</span><span class="o">-&gt;</span><span class="na">getBody</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x">&lt;/p&gt;</span>
<span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">stop</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The parent template is identified by a special string syntax
	      (<tt class="docutils literal"><span class="pre">::base.html.twig</span></tt>) that indicates that the template lives in the
	      <tt class="docutils literal"><span class="pre">app/Resources/views</span></tt> directory of the project. This naming convention is
	      explained fully in <a class="reference internal" href="#template-naming-locations"><em>Template Naming and Locations</em></a>.</p>
	</div></div>
	<p>The key to template inheritance is the <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">extends</span> <span class="pre">%}</span></tt> tag. This tells
	  the templating engine to first evaluate the base template, which sets up
	  the layout and defines several blocks. The child template is then rendered,
	  at which point the <tt class="docutils literal"><span class="pre">title</span></tt> and <tt class="docutils literal"><span class="pre">body</span></tt> blocks of the parent are replaced
	  by those from the child. Depending on the value of <tt class="docutils literal"><span class="pre">blog_entries</span></tt>, the
	  output might look like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;!</span><span class="nx">DOCTYPE</span> <span class="nx">html</span><span class="o">&gt;</span>
<span class="o">&lt;</span><span class="nx">html</span><span class="o">&gt;</span>
    <span class="o">&lt;</span><span class="nx">head</span><span class="o">&gt;</span>
        <span class="o">&lt;</span><span class="nx">meta</span> <span class="nx">http</span><span class="o">-</span><span class="nx">equiv</span><span class="o">=</span><span class="s2">"Content-Type"</span> <span class="nx">content</span><span class="o">=</span><span class="s2">"text/html; charset=utf-8"</span> <span class="o">/&gt;</span>
        <span class="o">&lt;</span><span class="nx">title</span><span class="o">&gt;</span><span class="nx">My</span> <span class="nx">cool</span> <span class="nx">blog</span> <span class="nx">posts</span><span class="o">&lt;/</span><span class="nx">title</span><span class="o">&gt;</span>
    <span class="o">&lt;/</span><span class="nx">head</span><span class="o">&gt;</span>
    <span class="o">&lt;</span><span class="nx">body</span><span class="o">&gt;</span>
        <span class="o">&lt;</span><span class="nx">div</span> <span class="nx">id</span><span class="o">=</span><span class="s2">"sidebar"</span><span class="o">&gt;</span>
            <span class="o">&lt;</span><span class="nx">ul</span><span class="o">&gt;</span>
                <span class="o">&lt;</span><span class="nx">li</span><span class="o">&gt;&lt;</span><span class="nx">a</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"/"</span><span class="o">&gt;</span><span class="nx">Home</span><span class="o">&lt;/</span><span class="nx">a</span><span class="o">&gt;&lt;/</span><span class="nx">li</span><span class="o">&gt;</span>
                <span class="o">&lt;</span><span class="nx">li</span><span class="o">&gt;&lt;</span><span class="nx">a</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"/blog"</span><span class="o">&gt;</span><span class="nx">Blog</span><span class="o">&lt;/</span><span class="nx">a</span><span class="o">&gt;&lt;/</span><span class="nx">li</span><span class="o">&gt;</span>
            <span class="o">&lt;/</span><span class="nx">ul</span><span class="o">&gt;</span>
        <span class="o">&lt;/</span><span class="nx">div</span><span class="o">&gt;</span>

        <span class="o">&lt;</span><span class="nx">div</span> <span class="nx">id</span><span class="o">=</span><span class="s2">"content"</span><span class="o">&gt;</span>
            <span class="o">&lt;</span><span class="nx">h2</span><span class="o">&gt;</span><span class="nx">My</span> <span class="nx">first</span> <span class="nx">post</span><span class="o">&lt;/</span><span class="nx">h2</span><span class="o">&gt;</span>
            <span class="o">&lt;</span><span class="nx">p</span><span class="o">&gt;</span><span class="nx">The</span> <span class="nx">body</span> <span class="nx">of</span> <span class="nx">the</span> <span class="nx">first</span> <span class="nx">post</span><span class="o">.&lt;/</span><span class="nx">p</span><span class="o">&gt;</span>

            <span class="o">&lt;</span><span class="nx">h2</span><span class="o">&gt;</span><span class="nx">Another</span> <span class="nx">post</span><span class="o">&lt;/</span><span class="nx">h2</span><span class="o">&gt;</span>
            <span class="o">&lt;</span><span class="nx">p</span><span class="o">&gt;</span><span class="nx">The</span> <span class="nx">body</span> <span class="nx">of</span> <span class="nx">the</span> <span class="nx">second</span> <span class="nx">post</span><span class="o">.&lt;/</span><span class="nx">p</span><span class="o">&gt;</span>
        <span class="o">&lt;/</span><span class="nx">div</span><span class="o">&gt;</span>
    <span class="o">&lt;/</span><span class="nx">body</span><span class="o">&gt;</span>
<span class="o">&lt;/</span><span class="nx">html</span><span class="o">&gt;</span>
	  </pre></div>
	</div>
	<p>Notice that since the child template didn't define a <tt class="docutils literal"><span class="pre">sidebar</span></tt> block, the
	  value from the parent template is used instead. Content within a <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt>
	  tag in a parent template is always used by default.</p>
	<p>You can use as many levels of inheritance as you want. In the next section,
	  a common three-level inheritance model will be explained along with how templates
	  are organized inside a Symfony2 project.</p>
	<p>When working with template inheritance, here are some tips to keep in mind:</p>
	<ul>
	  <li><p class="first">If you use <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">extends</span> <span class="pre">%}</span></tt> in a template, it must be the first tag in
	      that template.</p>
	  </li>
	  <li><p class="first">The more <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt> tags you have in your base templates, the better.
	      Remember, child templates don't have to define all parent blocks, so create
	      as many blocks in your base templates as you want and give each a sensible
	      default. The more blocks your base templates have, the more flexible your
	      layout will be.</p>
	  </li>
	  <li><p class="first">If you find yourself duplicating content in a number of templates, it probably
	      means you should move that content to a <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt> in a parent template.
	      In some cases, a better solution may be to move the content to a new template
	      and <tt class="docutils literal"><span class="pre">include</span></tt> it (see <a class="reference internal" href="#including-templates"><em>Including other Templates</em></a>).</p>
	  </li>
	  <li><p class="first">If you need to get the content of a block from the parent template, you
	      can use the <tt class="docutils literal"><span class="pre">{{</span> <span class="pre">parent()</span> <span class="pre">}}</span></tt> function. This is useful if you want to add
	      to the contents of a parent block instead of completely overriding it:</p>
	    <blockquote>
	      <div><div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">sidebar</span> <span class="cp">%}</span>
    <span class="nt">&lt;h3&gt;</span>Table of Contents<span class="nt">&lt;/h3&gt;</span>
    ...
    <span class="cp">{{</span> <span class="nv">parent</span><span class="o">()</span> <span class="cp">}}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	    </div></blockquote>
	  </li>
	</ul>
      </div>
      <div class="section" id="template-naming-and-locations">
	<span id="template-naming-locations"></span><span id="index-5"></span><h2>Template Naming and Locations<a class="headerlink" href="#template-naming-and-locations" title="Permalink to this headline">¶</a></h2>
	<p>By default, templates can live in two different locations:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">app/Resources/views/</span></tt> The applications <tt class="docutils literal"><span class="pre">views</span></tt> directory can contain
	    application-wide base templates (i.e. your application's layouts) as well as
	    templates that override bundle templates (see
	    <a class="reference internal" href="#overiding-bundle-templates"><em>Overriding Bundle Templates</em></a>);</li>
	  <li><tt class="docutils literal"><span class="pre">path/to/bundle/Resources/views/</span></tt> Each bundle houses its templates in its
	    <tt class="docutils literal"><span class="pre">Resources/views</span></tt> directory (and subdirectories). The majority of templates
	    will live inside a bundle.</li>
	</ul>
	<p>Symfony2 uses a <strong>bundle</strong>:<strong>controller</strong>:<strong>template</strong> string syntax for
	  templates. This allows for several different types of templates, each which
	  lives in a specific location:</p>
	<ul>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">AcmeBlogBundle:Blog:index.html.twig</span></tt>: This syntax is used to specify a
	      template for a specific page. The three parts of the string, each separated
	      by a colon (<tt class="docutils literal"><span class="pre">:</span></tt>), mean the following:</p>
	    <blockquote>
	      <div><ul class="simple">
		  <li><tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>: (<em>bundle</em>) the template lives inside the
		    <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> (e.g. <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle</span></tt>);</li>
		  <li><tt class="docutils literal"><span class="pre">Blog</span></tt>: (<em>controller</em>) indicates that the template lives inside the
		    <tt class="docutils literal"><span class="pre">Blog</span></tt> subdirectory of <tt class="docutils literal"><span class="pre">Resources/views</span></tt>;</li>
		  <li><tt class="docutils literal"><span class="pre">index.html.twig</span></tt>: (<em>template</em>) the actual name of the file is
		    <tt class="docutils literal"><span class="pre">index.html.twig</span></tt>.</li>
		</ul>
	    </div></blockquote>
	    <p>Assuming that the <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> lives at <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle</span></tt>, the
	      final path to the layout would be <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle/Resources/views/Blog/index.html.twig</span></tt>.</p>
	  </li>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">AcmeBlogBundle::layout.html.twig</span></tt>: This syntax refers to a base template
	      that's specific to the <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>. Since the middle, "controller",
	      portion is missing (e.g. <tt class="docutils literal"><span class="pre">Blog</span></tt>), the template lives at
	      <tt class="docutils literal"><span class="pre">Resources/views/layout.html.twig</span></tt> inside <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>.</p>
	  </li>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">::base.html.twig</span></tt>: This syntax refers to an application-wide base template
	      or layout. Notice that the string begins with two colons (<tt class="docutils literal"><span class="pre">::</span></tt>), meaning
	      that both the <em>bundle</em> and <em>controller</em> portions are missing. This means
	      that the template is not located in any bundle, but instead in the root
	      <tt class="docutils literal"><span class="pre">app/Resources/views/</span></tt> directory.</p>
	  </li>
	</ul>
	<p>In the <a class="reference internal" href="#overiding-bundle-templates"><em>Overriding Bundle Templates</em></a> section, you'll find out how each
	  template living inside the <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>, for example, can be overridden
	  by placing a template of the same name in the <tt class="docutils literal"><span class="pre">app/Resources/AcmeBlogBundle/views/</span></tt>
	  directory. This gives the power to override templates from any vendor bundle.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Hopefully the template naming syntax looks familiar - it's the same naming
	      convention used to refer to <a class="reference internal" href="routing.html#controller-string-syntax"><em>Controller Naming Pattern</em></a>.</p>
	</div></div>
	<div class="section" id="template-suffix">
	  <h3>Template Suffix<a class="headerlink" href="#template-suffix" title="Permalink to this headline">¶</a></h3>
	  <p>The <strong>bundle</strong>:<strong>controller</strong>:<strong>template</strong> format of each template specifies
	    <em>where</em>  the template file is located. Every template name also has two extensions
	    that specify the <em>format</em> and <em>engine</em> for that template.</p>
	  <ul class="simple">
	    <li><strong>AcmeBlogBundle:Blog:index.html.twig</strong> - HTML format, Twig engine</li>
	    <li><strong>AcmeBlogBundle:Blog:index.html.php</strong> - HTML format, PHP engine</li>
	    <li><strong>AcmeBlogBundle:Blog:index.css.twig</strong> - CSS format, Twig engine</li>
	  </ul>
	  <p>By default, any Symfony2 template can be written in either Twig or PHP, and
	    the last part of the extension (e.g. <tt class="docutils literal"><span class="pre">.twig</span></tt> or <tt class="docutils literal"><span class="pre">.php</span></tt>) specifies which
	    of these two <em>engines</em> should be used. The first part of the extension,
	    (e.g. <tt class="docutils literal"><span class="pre">.html</span></tt>, <tt class="docutils literal"><span class="pre">.css</span></tt>, etc) is the final format that the template will
	    generate. Unlike the engine, which determines how Symfony2 parses the template,
	    this is simply an organizational tactic used in case the same resource needs
	    to be rendered as HTML (<tt class="docutils literal"><span class="pre">index.html.twig</span></tt>), XML (<tt class="docutils literal"><span class="pre">index.xml.twig</span></tt>),
	    or any other format. For more information, read the <a class="reference internal" href="#template-formats"><em>Template Formats</em></a>
	    section.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The available "engines" can be configured and even new engines added.
		See <a class="reference internal" href="#template-configuration"><em>Templating Configuration</em></a> for more details.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="tags-and-helpers">
	<span id="index-6"></span><h2>Tags and Helpers<a class="headerlink" href="#tags-and-helpers" title="Permalink to this headline">¶</a></h2>
	<p>You already understand the basics of templates, how they're named and how
	  to use template inheritance. The hardest parts are already behind you. In
	  this section, you'll learn about a large group of tools available to help
	  perform the most common template tasks such as including other templates,
	  linking to pages and including images.</p>
	<p>Symfony2 comes bundled with several specialized Twig tags and functions that
	  ease the work of the template designer. In PHP, the templating system provides
	  an extensible <em>helper</em> system that provides useful features in a template
	  context.</p>
	<p>We've already seen a few built-in Twig tags (<tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt> &amp; <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">extends</span> <span class="pre">%}</span></tt>)
	  as well as an example of a PHP helper (<tt class="docutils literal"><span class="pre">$view['slots']</span></tt>). Let's learn a
	  few more.</p>
	<div class="section" id="including-other-templates">
	  <span id="including-templates"></span><span id="index-7"></span><h3>Including other Templates<a class="headerlink" href="#including-other-templates" title="Permalink to this headline">¶</a></h3>
	  <p>You'll often want to include the same template or code fragment on several
	    different pages. For example, in an application with "news articles", the
	    template code displaying an article might be used on the article detail page,
	    on a page displaying the most popular articles, or in a list of the latest
	    articles.</p>
	  <p>When you need to reuse a chunk of PHP code, you typically move the code to
	    a new PHP class or function. The same is true for templates. By moving the
	    reused template code into its own template, it can be included from any other
	    template. First, create the template that you'll need to reuse.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 184px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/ArticleBundle/Resources/Article/articleDetails.html.twig #}</span>
<span class="nt">&lt;h1&gt;</span><span class="cp">{{</span> <span class="nv">article.title</span> <span class="cp">}}</span><span class="nt">&lt;/h1&gt;</span>
<span class="nt">&lt;h3</span> <span class="na">class=</span><span class="s">"byline"</span><span class="nt">&gt;</span>by <span class="cp">{{</span> <span class="nv">article.authorName</span> <span class="cp">}}</span><span class="nt">&lt;/h3&gt;</span>

<span class="nt">&lt;p&gt;</span>
  <span class="cp">{{</span> <span class="nv">article.body</span> <span class="cp">}}</span>
<span class="nt">&lt;/p&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">src</span><span class="o">/</span><span class="nx">Acme</span><span class="o">/</span><span class="nx">ArticleBundle</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">Article</span><span class="o">/</span><span class="nx">articleDetails</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;</span><span class="nx">h2</span><span class="o">&gt;&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getTitle</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x">&lt;/h2&gt;</span>
<span class="x">&lt;h3 class="byline"&gt;by </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getAuthorName</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x">&lt;/h3&gt;</span>

<span class="x">&lt;p&gt;</span>
<span class="x">  </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getBody</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">&lt;/p&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Including this template from any other template is simple:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 253px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/ArticleBundle/Resources/Article/list.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'AcmeArticleBundle::layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}</span>
    <span class="nt">&lt;h1&gt;</span>Recent Articles<span class="nt">&lt;h1&gt;</span>

    <span class="cp">{%</span> <span class="k">for</span> <span class="nv">article</span> <span class="k">in</span> <span class="nv">articles</span> <span class="cp">%}</span>
        <span class="cp">{%</span> <span class="k">include</span> <span class="s1">'AcmeArticleBundle:Article:articleDetails.html.twig'</span> <span class="k">with</span> <span class="o">{</span><span class="s1">'article'</span><span class="o">:</span> <span class="nv">article</span><span class="o">}</span> <span class="cp">%}</span>
    <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">src</span><span class="o">/</span><span class="nx">Acme</span><span class="o">/</span><span class="nx">ArticleBundle</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">Article</span><span class="o">/</span><span class="k">list</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;?</span><span class="nx">php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'AcmeArticleBundle::layout.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>

<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">start</span><span class="p">(</span><span class="s1">'body'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;h1&gt;Recent Articles&lt;/h1&gt;</span>

<span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$articles</span> <span class="k">as</span> <span class="nv">$article</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">        </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeArticleBundle:Article:articleDetails.html.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'article'</span> <span class="o">=&gt;</span> <span class="nv">$article</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">stop</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x"></span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The template is included using the <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">include</span> <span class="pre">%}</span></tt> tag. Notice that the
	    template name follows the same typical convention. The <tt class="docutils literal"><span class="pre">articleDetails.html.twig</span></tt>
	    template uses an <tt class="docutils literal"><span class="pre">article</span></tt> variable. This is passed in by the <tt class="docutils literal"><span class="pre">list.html.twig</span></tt>
	    template using the <tt class="docutils literal"><span class="pre">with</span></tt> command.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The <tt class="docutils literal"><span class="pre">{'article':</span> <span class="pre">article}</span></tt> syntax is the standard Twig syntax for hash
		maps (i.e. an array with named keys). If we needed to pass in multiple
		elements, it would look like this: <tt class="docutils literal"><span class="pre">{'foo':</span> <span class="pre">foo,</span> <span class="pre">'bar':</span> <span class="pre">bar}</span></tt>.</p>
	  </div></div>
	</div>
	<div class="section" id="embedding-controllers">
	  <span id="templating-embedding-controller"></span><span id="index-8"></span><h3>Embedding Controllers<a class="headerlink" href="#embedding-controllers" title="Permalink to this headline">¶</a></h3>
	  <p>In some cases, you need to do more than include a simple template. Suppose
	    you have a sidebar in your layout that contains the three most recent articles.
	    Retrieving the three articles may include querying the database or performing
	    other heavy logic that can't be done from within a template.</p>
	  <p>The solution is to simply embed the result of an entire controller from your
	    template. First, create a controller that renders a certain number of recent
	    articles:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/ArticleBundle/Controller/ArticleController.php</span>

<span class="k">class</span> <span class="nc">ArticleController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">recentArticlesAction</span><span class="p">(</span><span class="nv">$max</span> <span class="o">=</span> <span class="mi">3</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// make a database call or other logic to get the "$max" most recent articles</span>
        <span class="nv">$articles</span> <span class="o">=</span> <span class="o">...</span><span class="p">;</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeArticleBundle:Article:recentList.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'articles'</span> <span class="o">=&gt;</span> <span class="nv">$articles</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">recentList</span></tt> template is perfectly straightforward:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 166px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/ArticleBundle/Resources/views/Article/recentList.html.twig #}</span>
<span class="cp">{%</span> <span class="k">for</span> <span class="nv">article</span> <span class="k">in</span> <span class="nv">articles</span> <span class="cp">%}</span>
  <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"/article/</span><span class="cp">{{</span> <span class="nv">article.slug</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
      <span class="cp">{{</span> <span class="nv">article.title</span> <span class="cp">}}</span>
  <span class="nt">&lt;/a&gt;</span>
<span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">src</span><span class="o">/</span><span class="nx">Acme</span><span class="o">/</span><span class="nx">ArticleBundle</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">Article</span><span class="o">/</span><span class="nx">recentList</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;?</span><span class="nx">php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$articles</span> <span class="nx">in</span> <span class="nv">$article</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;a href="/article/</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getSlug</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x">"&gt;</span>
<span class="x">        </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getTitle</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;/a&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Notice that we've cheated and hardcoded the article URL in this example
		(e.g. <tt class="docutils literal"><span class="pre">/article/*slug*</span></tt>). This is a bad practice. In the next section,
		you'll learn how to do this correctly.</p>
	  </div></div>
	  <p>To include the controller, you'll need to refer to it using the standard string
	    syntax for controllers (i.e. <strong>bundle</strong>:<strong>controller</strong>:<strong>action</strong>):</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 166px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# app/Resources/views/base.html.twig #}</span>
...

<span class="nt">&lt;div</span> <span class="na">id=</span><span class="s">"sidebar"</span><span class="nt">&gt;</span>
    <span class="cp">{%</span> <span class="k">render</span> <span class="s2">"AcmeArticleBundle:Article:recentArticles"</span> <span class="k">with</span> <span class="o">{</span><span class="s1">'max'</span><span class="o">:</span> <span class="m">3</span><span class="o">}</span> <span class="cp">%}</span>
<span class="nt">&lt;/div&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">app</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">base</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">...</span>

<span class="o">&lt;</span><span class="nx">div</span> <span class="nx">id</span><span class="o">=</span><span class="s2">"sidebar"</span><span class="o">&gt;</span>
    <span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'actions'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeArticleBundle:Article:recentArticles'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'max'</span> <span class="o">=&gt;</span> <span class="mi">3</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">&lt;/div&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Whenever you find that you need a variable or a piece of information that
	    you don't have access to in a template, consider rendering a controller.
	    Controllers are fast to execute and promote good code organization and reuse.</p>
	</div>
	<div class="section" id="linking-to-pages">
	  <span id="index-9"></span><h3>Linking to Pages<a class="headerlink" href="#linking-to-pages" title="Permalink to this headline">¶</a></h3>
	  <p>Creating links to other pages in your application is one of the most common
	    jobs for a template. Instead of hardcoding URLs in templates, use the <tt class="docutils literal"><span class="pre">path</span></tt>
	    Twig function (or the <tt class="docutils literal"><span class="pre">router</span></tt> helper in PHP) to generate URLs based on
	    the routing configuration. Later, if you want to modify the URL of a particular
	    page, all you'll need to do is change the routing configuration; the templates
	    will automatically generate the new URL.</p>
	  <p>First, link to the "homepage", which is accessible via the following routing
	    configuration:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">homepage</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">FrameworkBundle</span><span class="p-Indicator">:</span><span class="nv">Default</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"homepage"</span> <span class="na">pattern=</span><span class="s">"/"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>FrameworkBundle:Default:index<span class="nt">&lt;/default&gt;</span>
<span class="nt">&lt;/route&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'FrameworkBundle:Default:index'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>To link to the page, just use the <tt class="docutils literal"><span class="pre">path</span></tt> Twig function and refer to the route:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 76px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'homepage'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>Home<span class="nt">&lt;/a&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;</span><span class="nx">a</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['router']</span><span class="s2">-&gt;generate('homepage') ?&gt;"</span><span class="o">&gt;</span><span class="nx">Home</span><span class="o">&lt;/</span><span class="nx">a</span><span class="o">&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>As expected, this will generate the URL <tt class="docutils literal"><span class="pre">/</span></tt>. Let's see how this works with
	    a more complicated route:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">article_show</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/article/{slug}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeArticleBundle</span><span class="p-Indicator">:</span><span class="nv">Article</span><span class="p-Indicator">:</span><span class="nv">show</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"article_show"</span> <span class="na">pattern=</span><span class="s">"/article/{slug}"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeArticleBundle:Article:show<span class="nt">&lt;/default&gt;</span>
<span class="nt">&lt;/route&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'article_show'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/article/{slug}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeArticleBundle:Article:show'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>In this case, you need to specify both the route name (<tt class="docutils literal"><span class="pre">article_show</span></tt>) and
	    a value for the <tt class="docutils literal"><span class="pre">{slug}</span></tt> parameter. Using this route, let's revisit the
	    <tt class="docutils literal"><span class="pre">recentList</span></tt> template from the previous section and link to the articles
	    correctly:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 166px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/ArticleBundle/Resources/views/Article/recentList.html.twig #}</span>
<span class="cp">{%</span> <span class="k">for</span> <span class="nv">article</span> <span class="k">in</span> <span class="nv">articles</span> <span class="cp">%}</span>
  <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'article_show'</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'slug'</span><span class="o">:</span> <span class="nv">article.slug</span> <span class="o">})</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
      <span class="cp">{{</span> <span class="nv">article.title</span> <span class="cp">}}</span>
  <span class="nt">&lt;/a&gt;</span>
<span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">src</span><span class="o">/</span><span class="nx">Acme</span><span class="o">/</span><span class="nx">ArticleBundle</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">Article</span><span class="o">/</span><span class="nx">recentList</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;?</span><span class="nx">php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$articles</span> <span class="nx">in</span> <span class="nv">$article</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;a href="</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'router'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'article_show'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'slug'</span> <span class="o">=&gt;</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getSlug</span><span class="p">())</span> <span class="cp">?&gt;</span><span class="x">"&gt;</span>
<span class="x">        </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$article</span><span class="o">-&gt;</span><span class="na">getTitle</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;/a&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>You can also generate an absolute URL by using the <tt class="docutils literal"><span class="pre">url</span></tt> Twig function:</p>
	      <div class="highlight-html+jinja"><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">url</span><span class="o">(</span><span class="s1">'homepage'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>Home<span class="nt">&lt;/a&gt;</span>
		</pre></div>
	      </div>
	      <p>The same can be done in PHP templates by passing a third argument to
		the <tt class="docutils literal"><span class="pre">generate()</span></tt> method:</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="o">&lt;</span><span class="nx">a</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['router']</span><span class="s2">-&gt;generate('homepage', array(), true) ?&gt;"</span><span class="o">&gt;</span><span class="nx">Home</span><span class="o">&lt;/</span><span class="nx">a</span><span class="o">&gt;</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="linking-to-assets">
	  <span id="index-10"></span><h3>Linking to Assets<a class="headerlink" href="#linking-to-assets" title="Permalink to this headline">¶</a></h3>
	  <p>Templates also commonly refer to images, Javascript, stylesheets and other
	    assets. Of course you could hard-coded these the path to these assets
	    (e.g. <tt class="docutils literal"><span class="pre">/images/logo.png</span></tt>), but Symfony2 provides a more dynamic option
	    via the <tt class="docutils literal"><span class="pre">assets</span></tt> Twig function:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="nt">&lt;img</span> <span class="na">src=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">asset</span><span class="o">(</span><span class="s1">'images/logo.png'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span> <span class="na">alt=</span><span class="s">"Symfony!"</span> <span class="nt">/&gt;</span>

<span class="nt">&lt;link</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">asset</span><span class="o">(</span><span class="s1">'css/blog.css'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">type=</span><span class="s">"text/css"</span> <span class="nt">/&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;</span><span class="nx">img</span> <span class="nx">src</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['assets']</span><span class="s2">-&gt;getUrl('images/logo.png') ?&gt;"</span> <span class="nx">alt</span><span class="o">=</span><span class="s2">"Symfony!"</span> <span class="o">/&gt;</span>

<span class="o">&lt;</span><span class="nb">link</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['assets']</span><span class="s2">-&gt;getUrl('css/blog.css') ?&gt;"</span> <span class="nx">rel</span><span class="o">=</span><span class="s2">"stylesheet"</span> <span class="nx">type</span><span class="o">=</span><span class="s2">"text/css"</span> <span class="o">/&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">asset</span></tt> function's main purpose is to make your application more portable.
	    If your application lives at the root of your host (e.g. <a class="reference external" href="http://example.com">http://example.com</a>),
	    then the rendered paths should be <tt class="docutils literal"><span class="pre">/images/logo.png</span></tt>. But if your application
	    lives in a subdirectory (e.g. <a class="reference external" href="http://example.com/my_app">http://example.com/my_app</a>), each asset path
	    should render with the subdirectory (e.g. <tt class="docutils literal"><span class="pre">/my_app/images/logo.png</span></tt>). The
	    <tt class="docutils literal"><span class="pre">asset</span></tt> function takes care of this by determining how your application is
	    being used and generating the correct paths accordingly.</p>
	</div>
      </div>
      <div class="section" id="configuring-and-using-the-templating-service">
	<span id="index-11"></span><h2>Configuring and using the <tt class="docutils literal"><span class="pre">templating</span></tt> Service<a class="headerlink" href="#configuring-and-using-the-templating-service" title="Permalink to this headline">¶</a></h2>
	<p>The heart of the template system in Symfony2 is the templating <tt class="docutils literal"><span class="pre">Engine</span></tt>.
	  This special object is responsible for rendering templates and returning
	  their content. When you render a template in a controller, for example,
	  you're actually using the templating engine service. For example:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeArticleBundle:Article:index.html.twig'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>is equivalent to</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$engine</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'templating'</span><span class="p">);</span>
<span class="nv">$content</span> <span class="o">=</span> <span class="nv">$engine</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeArticleBundle:Article:index.html.twig'</span><span class="p">);</span>

<span class="k">return</span> <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$content</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p id="template-configuration">The templating engine (or "service") is preconfigured to work automatically
	  inside Symfony2. It can, of course, be configured further in the application
	  configuration file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">templating</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">engines</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="s">'twig'</span><span class="p-Indicator">]</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:templating</span> <span class="na">cache-warmer=</span><span class="s">"true"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;framework:engine</span> <span class="na">id=</span><span class="s">"twig"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:templating&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'templating'</span>      <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'engines'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Several configuration options are available and are covered in the
	  <a class="reference internal" href="../reference/configuration/framework.html"><em>Configuration Appendix</em></a>.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">twig</span></tt> engine is mandatory to use the webprofiler (as well as many
	      third-party bundles).</p>
	</div></div>
      </div>
      <div class="section" id="overriding-bundle-templates">
	<span id="overiding-bundle-templates"></span><span id="index-12"></span><h2>Overriding Bundle Templates<a class="headerlink" href="#overriding-bundle-templates" title="Permalink to this headline">¶</a></h2>
	<p>One of the best features of Symfony2 is a bundle system that encourages the
	  organization of components in a way that makes them easy to reuse in other
	  projects or distribute as open source libraries. In fact, the Symfony2 community
	  prides itself on creating and maintaining high quality bundles for a large
	  number of different features. To find out more about the open source bundles
	  that are available, visit <a class="reference external" href="http://symfony2bundles.org">Symfony2Bundles.org</a></p>
	<p>In Symfony2, almost every part of a bundle can be overridden so that you can
	  use and customize it for your specific application. Templates are no exception.</p>
	<p>Suppose you've included the imaginary open-source <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> in your
	  project (e.g. in the <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle</span></tt> directory). And while you're
	  really happy with everything, you want to override the blog "list" page to
	  customize the markup specifically for your application. By digging into the
	  <tt class="docutils literal"><span class="pre">Blog</span></tt> controller of the <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>, you find the following:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$blogs</span> <span class="o">=</span> <span class="c1">// some logic to retrieve the blogs</span>

    <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Blog:index.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'blogs'</span> <span class="o">=&gt;</span> <span class="nv">$blogs</span><span class="p">));</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>We learned in the <a class="reference internal" href="#template-naming-locations"><em>Template Naming and Locations</em></a> section that the template
	  in question lives at <tt class="docutils literal"><span class="pre">Resources/views/Blog/index.html.twig</span></tt> inside the
	  <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> bundle. To override the bundle template, copy the <tt class="docutils literal"><span class="pre">index.html.twig</span></tt>
	  template to <tt class="docutils literal"><span class="pre">app/Resources/AcmeBlogBundle/views/Blog/index.html.twig</span></tt> (the
	  <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> directory might not exist). Now, when the
	  <tt class="docutils literal"><span class="pre">AcmeBlogBundle:Blog:index.html.twig</span></tt> template is rendered, Symfony2 will look
	  first for the template at
	  <tt class="docutils literal"><span class="pre">app/Resources/AcmeBlogBundle/views/Blog/index.html.twig</span></tt> before looking
	  at  <tt class="docutils literal"><span class="pre">src/Acme/BlogBundle/Resources/views/Blog/index.html.twig</span></tt>. You're
	  now free to customize the template for your application.</p>
	<p>Suppose also that each template in <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> inherits from a base
	  template specific to the <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> called
	  <tt class="docutils literal"><span class="pre">AcmeBlogBundle::layout.html.twig</span></tt>. By default, this template lives at
	  <tt class="docutils literal"><span class="pre">Resources/views/layout.html.twig</span></tt> inside <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>. To override
	  it, just copy it to <tt class="docutils literal"><span class="pre">app/Resources/AcmeBlogBundle/views/layout.html.twig</span></tt>.</p>
	<p>If you take a step back, you'll see that Symfony2 always starts by looking in
	  the <tt class="docutils literal"><span class="pre">app/Resources/BUNDLE_NAME/views/</span></tt> directory for a template. If the
	  template doesn't exist there, it continues by checking inside the
	  <tt class="docutils literal"><span class="pre">Resources/views</span></tt> directory of the bundle itself. This means that all bundle
	  templates can be overridden by placing them in the correct <tt class="docutils literal"><span class="pre">app/Resources</span></tt>
	  subdirectory.</p>
	<span class="target" id="templating-overriding-core-templates"></span><div class="section" id="overriding-core-templates">
	  <span id="index-13"></span><h3>Overriding Core Templates<a class="headerlink" href="#overriding-core-templates" title="Permalink to this headline">¶</a></h3>
	  <p>Since the Symfony2 framework itself is just a bundle, core templates can be
	    overridden in the same way. For example, the core <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> contains
	    a number of different "exception" and "error" templates that can be overridden
	    by copying each from the <tt class="docutils literal"><span class="pre">Resources/views/Exception</span></tt> directory of the
	    <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> to, you guessed it, the
	    <tt class="docutils literal"><span class="pre">app/Resources/FrameworkBundle/views/Exception</span></tt> directory.</p>
	</div>
      </div>
      <div class="section" id="three-level-inheritance">
	<span id="index-14"></span><h2>Three-level Inheritance<a class="headerlink" href="#three-level-inheritance" title="Permalink to this headline">¶</a></h2>
	<p>One common way to use inheritance is to use a three-level approach. This
	  method works perfectly with the three different types of templates we've just
	  covered:</p>
	<ul>
	  <li><p class="first">Create a <tt class="docutils literal"><span class="pre">app/Resources/views/base.html.twig</span></tt> file that contains the main
	      layout for your application (like in the previous example). Internally, this
	      template is called <tt class="docutils literal"><span class="pre">::base.html.twig</span></tt>;</p>
	  </li>
	  <li><p class="first">Create a template for each "section" of your site. For example, an <tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt>,
	      would have a template called <tt class="docutils literal"><span class="pre">AcmeBlogBundle::layout.html.twig</span></tt> that contains
	      only blog section-specific elements;</p>
	    <blockquote>
	      <div><div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# src/Acme/BlogBundle/Resources/views/layout.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'::base.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}</span>
    <span class="nt">&lt;h1&gt;</span>Blog Application<span class="nt">&lt;/h1&gt;</span>

    <span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	    </div></blockquote>
	  </li>
	  <li><p class="first">Create individual templates for each page and make each extend the appropriate
	      section template. For example, the "index" page would be called something
	      close to <tt class="docutils literal"><span class="pre">AcmeBlogBundle:Blog:index.html.twig</span></tt> and list the actual blog posts.</p>
	    <blockquote>
	      <div><div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# src/Acme/BlogBundle/Resources/views/Blog/index.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'AcmeBlogBundle::layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span>
    <span class="cp">{%</span> <span class="k">for</span> <span class="nv">entry</span> <span class="k">in</span> <span class="nv">blog_entries</span> <span class="cp">%}</span>
        <span class="nt">&lt;h2&gt;</span><span class="cp">{{</span> <span class="nv">entry.title</span> <span class="cp">}}</span><span class="nt">&lt;/h2&gt;</span>
        <span class="nt">&lt;p&gt;</span><span class="cp">{{</span> <span class="nv">entry.body</span> <span class="cp">}}</span><span class="nt">&lt;/p&gt;</span>
    <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	    </div></blockquote>
	  </li>
	</ul>
	<p>Notice that this template extends the section template -(<tt class="docutils literal"><span class="pre">AcmeBlogBundle::layout.html.twig</span></tt>)
	  which in-turn extends the base application layout (<tt class="docutils literal"><span class="pre">::base.html.twig</span></tt>).
	  This is the common three-level inheritance model.</p>
	<p>When building your application, you may choose to follow this method or simply
	  make each page template extend the base application template directly
	  (e.g. <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">extends</span> <span class="pre">'::base.html.twig'</span> <span class="pre">%}</span></tt>). The three-template model is
	  a best-practice method used by vendor bundles so that the base template for
	  a bundle can be easily overridden to properly extend your application's base
	  layout.</p>
      </div>
      <div class="section" id="output-escaping">
	<span id="index-15"></span><h2>Output Escaping<a class="headerlink" href="#output-escaping" title="Permalink to this headline">¶</a></h2>
	<p>When generating HTML from a template, there is always a risk that a template
	  variable may output unintended HTML or dangerous client-side code. The result
	  is that dynamic content could break the HTML of the resulting page or allow
	  a malicious user to perform a <a class="reference external" href="http://en.wikipedia.org/wiki/Cross-site_scripting">Cross Site Scripting</a> (XSS) attack. Consider
	  this classic example:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 76px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="x">Hello </span><span class="cp">{{</span> <span class="nv">name</span> <span class="cp">}}</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nx">Hello</span> <span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$name</span> <span class="cp">?&gt;</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Imagine that the user enters the following code as his/her name:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;</span><span class="nx">script</span><span class="o">&gt;</span><span class="nx">alert</span><span class="p">(</span><span class="s1">'hello!'</span><span class="p">)</span><span class="o">&lt;/</span><span class="nx">script</span><span class="o">&gt;</span>
	  </pre></div>
	</div>
	<p>Without any output escaping, the resulting template will cause a JavaScript
	  alert box to pop up:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">Hello</span> <span class="o">&lt;</span><span class="nx">script</span><span class="o">&gt;</span><span class="nx">alert</span><span class="p">(</span><span class="s1">'hello!'</span><span class="p">)</span><span class="o">&lt;/</span><span class="nx">script</span><span class="o">&gt;</span>
	  </pre></div>
	</div>
	<p>And while this seems harmless, if a user can get this far, that same user
	  should also be able to write JavaScript that performs malicious actions
	  inside the secure area of an unknowing, legitimate user.</p>
	<p>The answer to the problem is output escaping. With output escaping on, the
	  same template will render harmlessly, and literally print the <tt class="docutils literal"><span class="pre">script</span></tt>
	  tag to the screen:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">Hello</span> <span class="o">&amp;</span><span class="nx">lt</span><span class="p">;</span><span class="nx">script</span><span class="o">&amp;</span><span class="nx">gt</span><span class="p">;</span><span class="nx">alert</span><span class="p">(</span><span class="o">&amp;</span><span class="c1">#39;helloe&amp;#39;)&amp;lt;/script&amp;gt;</span>
	  </pre></div>
	</div>
	<p>The Twig and PHP templating systems approach the problem in different ways.
	  If you're using Twig, output escaping is on by default and you're protected.
	  In PHP, output escaping is not automatic, meaning you'll need to manually
	  escape where necessary.</p>
	<div class="section" id="output-escaping-in-twig">
	  <h3>Output Escaping in Twig<a class="headerlink" href="#output-escaping-in-twig" title="Permalink to this headline">¶</a></h3>
	  <p>If you're using Twig templates, then output escaping is on by default. This
	    means that you're protected out-of-the-box from the unintentional consequences
	    of user-submitted code. By default, the output escaping assumes that content
	    is being escaped for HTML output.</p>
	  <p>In some cases, you'll need to disable output escaping when you're rendering
	    a variable that is trusted and contains markup that should not be escaped.
	    Suppose that administrative users are able to write articles that contain
	    HTML code. By default, Twig will escape the article body. To render it normally,
	    add the <tt class="docutils literal"><span class="pre">raw</span></tt> filter: <tt class="docutils literal"><span class="pre">{{</span> <span class="pre">article.body</span> <span class="pre">|</span> <span class="pre">raw</span> <span class="pre">}}</span></tt>.</p>
	  <p>You can also to disable output escaping inside a <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt> area or
	    for an entire template. For more information, see <a class="reference external" href="http://www.twig-project.org">Output Escaping</a> in
	    the Twig documentation.</p>
	</div>
	<div class="section" id="output-escaping-in-php">
	  <h3>Output Escaping in PHP<a class="headerlink" href="#output-escaping-in-php" title="Permalink to this headline">¶</a></h3>
	  <p>Output escaping is not automatic when using PHP templates. This means that
	    unless you explicitly choose to escape a variable, you're not protected. To
	    use output escaping, use the special <tt class="docutils literal"><span class="pre">escape()</span></tt> view method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nx">Hello</span> <span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>By default, the <tt class="docutils literal"><span class="pre">escape()</span></tt> method assumes that the variable is being rendered
	    within an HTML context (and thus the variable is escaped to be safe for HTML).
	    The second argument lets you change the context. For example, to output something
	    in a JavaScript string, use the <tt class="docutils literal"><span class="pre">js</span></tt> context:</p>
	  <div class="highlight-js"><div class="highlight"><pre><span class="kd">var</span> <span class="nx">myMsg</span> <span class="o">=</span> <span class="s1">'Hello &lt;?php echo $view-&gt;escape($name, '</span><span class="nx">js</span><span class="s1">') ?&gt;'</span><span class="p">;</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="template-formats">
	<span id="index-16"></span><span id="id1"></span><h2>Template Formats<a class="headerlink" href="#template-formats" title="Permalink to this headline">¶</a></h2>
	<p>Templates are a generic way to render content in <em>any</em> format. And while in
	  most cases you'll use templates to render HTML content, a template can just
	  as easily generate JavaScript, CSS, XML or any other format you can dream of.</p>
	<p>For example, the same "resource" is often rendered in several different formats.
	  To render an article index page in XML, simply include the format in the
	  template name:</p>
	<p><em>XML template name</em>: <tt class="docutils literal"><span class="pre">AcmeArticleBundle:Article:index.xml.twig</span></tt>
	  <em>XML template filename</em>: <tt class="docutils literal"><span class="pre">index.xml.twig</span></tt></p>
	<p>In reality, this is nothing more than a naming convention and the template
	  isn't actually rendered differently based on its format.</p>
	<p>In many cases, you may want to allow a single controller to render multiple
	  different formats based on the "request format". For that reason, a common
	  pattern is to do the following:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$format</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getRequestFormat</span><span class="p">();</span>

    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Blog:index.'</span><span class="o">.</span><span class="nv">$format</span><span class="o">.</span><span class="s1">'.twig'</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">getRequestFormat</span></tt> on the <tt class="docutils literal"><span class="pre">Request</span></tt> object defaults to <tt class="docutils literal"><span class="pre">html</span></tt>,
	  but can return any other format based on the format requested by the user.
	  The request format is most often managed by the routing, where a route can
	  be configured so that <tt class="docutils literal"><span class="pre">/contact</span></tt> sets the request format to <tt class="docutils literal"><span class="pre">html</span></tt> while
	  <tt class="docutils literal"><span class="pre">/contact.xml</span></tt> sets the format to <tt class="docutils literal"><span class="pre">xml</span></tt>. For more information, see the
	  <a class="reference internal" href="routing.html#advanced-routing-example"><em>Advanced Example in the Routing chapter</em></a>.</p>
	<p>To create links that include the format parameter, include a <tt class="docutils literal"><span class="pre">_format</span></tt>
	  key in the parameter hash:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'article_show'</span><span class="o">,</span> <span class="o">{</span><span class="s1">'id'</span><span class="o">:</span> <span class="m">123</span><span class="o">,</span> <span class="s1">'_format'</span><span class="o">:</span> <span class="s1">'pdf'</span><span class="o">})</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
        PDF Version
    <span class="nt">&lt;/a&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'router'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'article_show'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'id'</span> <span class="o">=&gt;</span> <span class="mi">123</span><span class="p">,</span> <span class="s1">'_format'</span> <span class="o">=&gt;</span> <span class="s1">'pdf'</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;</span>
    PDF Version
<span class="nt">&lt;/a&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="final-thoughts">
	<h2>Final Thoughts<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>The templating engine in Symfony is a powerful tool that can be used each time
	  you need to generate presentational content in HTML, XML or any other format.
	  And though templates are a common way to generate content in a controller,
	  their use is not mandatory. The <tt class="docutils literal"><span class="pre">Response</span></tt> object returned by a controller
	  can be created with our without the use of a template:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// creates a Response object whose content is the rendered template</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeArticleBundle:Article:index.html.twig'</span><span class="p">);</span>

<span class="c1">// creates a Response object whose content is simple text</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'response content'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Symfony's templating engine is very flexible and two different template
	  renderers are available by default: the traditional <em>PHP</em> templates and the
	  sleek and powerful <em>Twig</em> templates. Both support a template hierarchy and
	  come packaged with a rich set of helper functions capable of performing
	  the most common tasks.</p>
	<p>Overall, the topic of templating should be thought of as a powerful tool
	  that's at your disposal. In some cases, you may not need to render a template,
	  and in Symfony2, that's absolutely fine.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/templating/PHP.html"><em>How to use PHP instead of Twig for Templates</em></a></li>
	  <li><a class="reference internal" href="../cookbook/controller/error_pages.html"><em>How to customize Error Pages</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Routing" href="routing.html">
      «&nbsp;Routing
    </a><span class="separator">|</span>
    <a accesskey="N" title="Databases and Doctrine (&quot;The Model&quot;)" href="doctrine.html">
      Databases and Doctrine ("The Model")&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
