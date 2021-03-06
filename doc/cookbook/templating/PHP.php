<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to use PHP instead of Twig for Templates</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-php-instead-of-twig-for-templates">
      <span id="index-0"></span><h1>How to use PHP instead of Twig for Templates<a class="headerlink" href="#how-to-use-php-instead-of-twig-for-templates" title="Permalink to this headline">¶</a></h1>
      <p>Even if Symfony2 defaults to Twig for its template engine, you can still use
	plain PHP code if you want. Both templating engines are supported equally in
	Symfony2. Symfony2 adds some nice features on top of PHP to make writing
	templates with PHP more powerful.</p>
      <div class="section" id="rendering-php-templates">
	<h2>Rendering PHP Templates<a class="headerlink" href="#rendering-php-templates" title="Permalink to this headline">¶</a></h2>
	<p>If you want to use the PHP templating engine, first, make sure to enable it in
	  your application configuration file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">templating</span><span class="p-Indicator">:</span>    <span class="p-Indicator">{</span> <span class="nv">engines</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="s">'twig'</span><span class="p-Indicator">,</span> <span class="s">'php'</span><span class="p-Indicator">]</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- app/config/config.xml --&gt;
&lt;framework:config ... &gt;
    &lt;!-- ... --&gt;
    &lt;framework:templating ... &gt;
        &lt;framework:engine id="twig" /&gt;
        &lt;framework:engine id="php" /&gt;
    &lt;/framework:templating&gt;
		  &lt;/framework:config&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'templating'</span>      <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'engines'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">,</span> <span class="s1">'php'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>You can now render a PHP template instead of a Twig one simply by using the
	  <tt class="docutils literal"><span class="pre">.php</span></tt> extension in the template name instead of <tt class="docutils literal"><span class="pre">.twig</span></tt>. The controller
	  below renders the <tt class="docutils literal"><span class="pre">index.html.php</span></tt> template:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'HelloBundle:Hello:index.html.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">));</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="decorating-templates">
	<span id="index-1"></span><h2>Decorating Templates<a class="headerlink" href="#decorating-templates" title="Permalink to this headline">¶</a></h2>
	<p>More often than not, templates in a project share common elements, like the
	  well-known header and footer. In Symfony2, we like to think about this problem
	  differently: a template can be decorated by another one.</p>
	<p>The <tt class="docutils literal"><span class="pre">index.html.php</span></tt> template is decorated by <tt class="docutils literal"><span class="pre">layout.html.php</span></tt>, thanks to
	  the <tt class="docutils literal"><span class="pre">extend()</span></tt> call:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/views/Hello/index.html.php --&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'AcmeHelloBundle::layout.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span>

Hello <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$name</span> <span class="cp">?&gt;</span>!
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">HelloBundle::layout.html.php</span></tt> notation sounds familiar, doesn't it? It
	  is the same notation used to reference a template. The <tt class="docutils literal"><span class="pre">::</span></tt> part simply
	  means that the controller element is empty, so the corresponding file is
	  directly stored under <tt class="docutils literal"><span class="pre">views/</span></tt>.</p>
	<p>Now, let's have a look at the <tt class="docutils literal"><span class="pre">layout.html.php</span></tt> file:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/views/layout.html.php --&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'::base.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="nt">&lt;h1&gt;</span>Hello Application<span class="nt">&lt;/h1&gt;</span>

<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'_content'</span><span class="p">)</span> <span class="cp">?&gt;</span>
	  </pre></div>
	</div>
	<p>The layout is itself decorated by another one (<tt class="docutils literal"><span class="pre">::base.html.php</span></tt>). Symfony2
	  supports multiple decoration levels: a layout can itself be decorated by
	  another one. When the bundle part of the template name is empty, views are
	  looked for in the <tt class="docutils literal"><span class="pre">app/Resources/views/</span></tt> directory. This directory store
	  global views for your entire project:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- app/Resources/views/base.html.php --&gt;</span>
<span class="cp">&lt;!DOCTYPE html&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;meta</span> <span class="na">http-equiv=</span><span class="s">"Content-Type"</span> <span class="na">content=</span><span class="s">"text/html; charset=utf-8"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;title&gt;</span><span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'Hello Application'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'_content'</span><span class="p">)</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	  </pre></div>
	</div>
	<p>For both layouts, the <tt class="docutils literal"><span class="pre">$view['slots']-&gt;output('_content')</span></tt> expression is
	  replaced by the content of the child template, <tt class="docutils literal"><span class="pre">index.html.php</span></tt> and
	  <tt class="docutils literal"><span class="pre">layout.html.php</span></tt> respectively (more on slots in the next section).</p>
	<p>As you can see, Symfony2 provides methods on a mysterious <tt class="docutils literal"><span class="pre">$view</span></tt> object. In
	  a template, the <tt class="docutils literal"><span class="pre">$view</span></tt> variable is always available and refers to a special
	  object that provides a bunch of methods that makes the template engine tick.</p>
      </div>
      <div class="section" id="working-with-slots">
	<span id="index-2"></span><h2>Working with Slots<a class="headerlink" href="#working-with-slots" title="Permalink to this headline">¶</a></h2>
	<p>A slot is a snippet of code, defined in a template, and reusable in any layout
	  decorating the template. In the <tt class="docutils literal"><span class="pre">index.html.php</span></tt> template, define a
	  <tt class="docutils literal"><span class="pre">title</span></tt> slot:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/views/Hello/index.html.php --&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'AcmeHelloBundle::layout.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'Hello World Application'</span><span class="p">)</span> <span class="cp">?&gt;</span>

Hello <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$name</span> <span class="cp">?&gt;</span>!
	  </pre></div>
	</div>
	<p>The base layout already has the code to output the title in the header:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- app/Resources/views/layout.html.php --&gt;</span>
<span class="nt">&lt;head&gt;</span>
    <span class="nt">&lt;meta</span> <span class="na">http-equiv=</span><span class="s">"Content-Type"</span> <span class="na">content=</span><span class="s">"text/html; charset=utf-8"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;title&gt;</span><span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'Hello Application'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="nt">&lt;/title&gt;</span>
<span class="nt">&lt;/head&gt;</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">output()</span></tt> method inserts the content of a slot and optionally takes a
	  default value if the slot is not defined. And <tt class="docutils literal"><span class="pre">_content</span></tt> is just a special
	  slot that contains the rendered child template.</p>
	<p>For large slots, there is also an extended syntax:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">start</span><span class="p">(</span><span class="s1">'title'</span><span class="p">)</span> <span class="cp">?&gt;</span>
    Some large amount of HTML
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">stop</span><span class="p">()</span> <span class="cp">?&gt;</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="including-other-templates">
	<span id="index-3"></span><h2>Including other Templates<a class="headerlink" href="#including-other-templates" title="Permalink to this headline">¶</a></h2>
	<p>The best way to share a snippet of template code is to define a template that
	  can then be included into other templates.</p>
	<p>Create a <tt class="docutils literal"><span class="pre">hello.html.php</span></tt> template:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/views/Hello/hello.html.php --&gt;</span>
Hello <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$name</span> <span class="cp">?&gt;</span>!
	  </pre></div>
	</div>
	<p>And change the <tt class="docutils literal"><span class="pre">index.html.php</span></tt> template to include it:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/views/Hello/index.html.php --&gt;</span>
<span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'AcmeHelloBundle::layout.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeHello:Hello:hello.html.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">))</span> <span class="cp">?&gt;</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">render()</span></tt> method evaluates and returns the content of another template
	  (this is the exact same method as the one used in the controller).</p>
      </div>
      <div class="section" id="embedding-other-controllers">
	<span id="index-4"></span><h2>Embedding other Controllers<a class="headerlink" href="#embedding-other-controllers" title="Permalink to this headline">¶</a></h2>
	<p>And what if you want to embed the result of another controller in a template?
	  That's very useful when working with Ajax, or when the embedded template needs
	  some variable not available in the main template.</p>
	<p>If you create a <tt class="docutils literal"><span class="pre">fancy</span></tt> action, and want to include it into the
	  <tt class="docutils literal"><span class="pre">index.html.php</span></tt> template, simply use the following code:</p>
	<div class="highlight-html+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/views/Hello/index.html.php --&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'actions'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'HelloBundle:Hello:fancy'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span> <span class="s1">'color'</span> <span class="o">=&gt;</span> <span class="s1">'green'</span><span class="p">))</span> <span class="cp">?&gt;</span>
	  </pre></div>
	</div>
	<p>Here, the <tt class="docutils literal"><span class="pre">HelloBundle:Hello:fancy</span></tt> string refers to the <tt class="docutils literal"><span class="pre">fancy</span></tt> action of the
	  <tt class="docutils literal"><span class="pre">Hello</span></tt> controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>

<span class="k">class</span> <span class="nc">HelloController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">fancyAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// create some object, based on the $color variable</span>
        <span class="nv">$object</span> <span class="o">=</span> <span class="o">...</span><span class="p">;</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'HelloBundle:Hello:fancy.html.php'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span> <span class="s1">'object'</span> <span class="o">=&gt;</span> <span class="nv">$object</span><span class="p">));</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>But where is the <tt class="docutils literal"><span class="pre">$view['actions']</span></tt> array element defined? Like
	  <tt class="docutils literal"><span class="pre">$view['slots']</span></tt>, it's called a template helper, and the next section tells
	  you more about those.</p>
      </div>
      <div class="section" id="using-template-helpers">
	<span id="index-5"></span><h2>Using Template Helpers<a class="headerlink" href="#using-template-helpers" title="Permalink to this headline">¶</a></h2>
	<p>The Symfony2 templating system can be easily extended via helpers. Helpers are
	  PHP objects that provide features useful in a template context. <tt class="docutils literal"><span class="pre">actions</span></tt> and
	  <tt class="docutils literal"><span class="pre">slots</span></tt> are two of the built-in Symfony2 helpers.</p>
	<div class="section" id="creating-links-between-pages">
	  <h3>Creating Links between Pages<a class="headerlink" href="#creating-links-between-pages" title="Permalink to this headline">¶</a></h3>
	  <p>Speaking of web applications, creating links between pages is a must. Instead
	    of hardcoding URLs in templates, the <tt class="docutils literal"><span class="pre">router</span></tt> helper knows how to generate
	    URLs based on the routing configuration. That way, all your URLs can be easily
	    updated by changing the configuration:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'router'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'hello'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="s1">'Thomas'</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;</span>
    Greet Thomas!
<span class="nt">&lt;/a&gt;</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">generate()</span></tt> method takes the route name and an array of parameters as
	    arguments. The route name is the main key under which routes are referenced
	    and the parameters are the values of the placeholders defined in the route
	    pattern:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/routing.yml</span>
<span class="l-Scalar-Plain">hello</span><span class="p-Indicator">:</span> <span class="c1"># The route name</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/hello/{name}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeHelloBundle</span><span class="p-Indicator">:</span><span class="nv">Hello</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="using-assets-images-javascripts-and-stylesheets">
	  <h3>Using Assets: images, JavaScripts, and stylesheets<a class="headerlink" href="#using-assets-images-javascripts-and-stylesheets" title="Permalink to this headline">¶</a></h3>
	  <p>What would the Internet be without images, JavaScripts, and stylesheets?
	    Symfony2 provides the <tt class="docutils literal"><span class="pre">assets</span></tt> tag to deal with them easily:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="nt">&lt;link</span> <span class="na">href=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'assets'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">getUrl</span><span class="p">(</span><span class="s1">'css/blog.css'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="s">"</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">type=</span><span class="s">"text/css"</span> <span class="nt">/&gt;</span>

<span class="nt">&lt;img</span> <span class="na">src=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'assets'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">getUrl</span><span class="p">(</span><span class="s1">'images/logo.png'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="s">"</span> <span class="nt">/&gt;</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">assets</span></tt> helper's main purpose is to make your application more
	    portable. Thanks to this helper, you can move the application root directory
	    anywhere under your web root directory without changing anything in your
	    template's code.</p>
	</div>
      </div>
      <div class="section" id="output-escaping">
	<h2>Output Escaping<a class="headerlink" href="#output-escaping" title="Permalink to this headline">¶</a></h2>
	<p>When using PHP templates, escape variables whenever they are displayed to the
	  user:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$var</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>By default, the <tt class="docutils literal"><span class="pre">escape()</span></tt> method assumes that the variable is outputted
	  within an HTML context. The second argument lets you change the context. For
	  instance, to output something in a JavaScript script, use the <tt class="docutils literal"><span class="pre">js</span></tt> context:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$var</span><span class="p">,</span> <span class="s1">'js'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to Minify JavaScripts and Stylesheets with YUI Compressor" href="../assetic/yuicompressor.html">
      «&nbsp;How to Minify JavaScripts and Stylesheets with YUI Compressor
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to create Fixtures in Symfony2" href="../doctrine/doctrine_fixtures.html">
      How to create Fixtures in Symfony2&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
