<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How Symfony2 differs from symfony1</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-symfony2-differs-from-symfony1">
      <h1>How Symfony2 differs from symfony1<a class="headerlink" href="#how-symfony2-differs-from-symfony1" title="Permalink to this headline">¶</a></h1>
      <p>The Symfony2 framework embodies a significant evolution when compared with
	the first version of the framework. Fortunately, with the MVC architecture
	at its core, the skills used to master a symfony1 project continue to be
	very relevant when developing in Symfony2. Sure, <tt class="docutils literal"><span class="pre">app.yml</span></tt> is gone, but
	routing, controllers and templates all remain.</p>
      <p>In this chapter, we'll walk through the differences between symfony1 and Symfony2.
	As you'll see, many tasks are tackled in a slightly different way. You'll
	come to appreciate these minor differences as they promote stable, predictable,
	testable and decoupled code in your Symfony2 applications.</p>
      <p>So, sit back and relax as we take you from "then" to "now".</p>
      <div class="section" id="directory-structure">
	<h2>Directory Structure<a class="headerlink" href="#directory-structure" title="Permalink to this headline">¶</a></h2>
	<p>When looking at a Symfony2 project - for example, the <a class="reference external" href="https://github.com/symfony/symfony-standard">Symfony2 Standard</a> -
	  you'll notice a very different directory structure than in symfony1. The
	  differences, however, are somewhat superficial.</p>
	<div class="section" id="the-app-directory">
	  <h3>The <tt class="docutils literal"><span class="pre">app/</span></tt> Directory<a class="headerlink" href="#the-app-directory" title="Permalink to this headline">¶</a></h3>
	  <p>In symfony1, your project has one or more applications, and each lives inside
	    the <tt class="docutils literal"><span class="pre">apps/</span></tt> directory (e.g. <tt class="docutils literal"><span class="pre">apps/frontend</span></tt>). By default in Symfony2,
	    you have just one application represented by the <tt class="docutils literal"><span class="pre">app/</span></tt> directory. Like
	    in symfony1, the <tt class="docutils literal"><span class="pre">app/</span></tt> directory contains configuration specific to that
	    application. It also contains application-specific cache, log and template
	    directories as well as a <tt class="docutils literal"><span class="pre">Kernel</span></tt> class (<tt class="docutils literal"><span class="pre">AppKernel</span></tt>), which is the base
	    object that represents the application.</p>
	  <p>Unlike symfony1, almost no PHP code lives in the <tt class="docutils literal"><span class="pre">app/</span></tt> directory. This
	    directory is not meant to house modules or library files as it did in symfony1.
	    Instead, it's simply the home of configuration and other resources (templates,
	    translation files).</p>
	</div>
	<div class="section" id="the-src-directory">
	  <h3>The <tt class="docutils literal"><span class="pre">src/</span></tt> Directory<a class="headerlink" href="#the-src-directory" title="Permalink to this headline">¶</a></h3>
	  <p>Put simply, your actual code goes here. In Symfony2, all actual application-code
	    lives inside a bundle (roughly equivalent to a symfony1 plugin) and, by default,
	    each bundle lives inside the <tt class="docutils literal"><span class="pre">src</span></tt> directory. In that way, the <tt class="docutils literal"><span class="pre">src</span></tt>
	    directory is a bit like the <tt class="docutils literal"><span class="pre">plugins</span></tt> directory in symfony1, but much more
	    flexible. Additionally, while <em>your</em> bundles will live in the <tt class="docutils literal"><span class="pre">src/</span></tt> directory,
	    third-party bundles may live in the <tt class="docutils literal"><span class="pre">vendor/</span></tt> directory.</p>
	  <p>To get a better picture of the <tt class="docutils literal"><span class="pre">src/</span></tt> directory, let's first think of a
	    symfony1 application. First, part of your code likely lives inside one or
	    more applications. Most commonly these include modules, but could also include
	    any other PHP classes you put in your application. You may have also created
	    a <tt class="docutils literal"><span class="pre">schema.yml</span></tt> file in the <tt class="docutils literal"><span class="pre">config</span></tt> directory of your project and built
	    several model files. Finally, to help with some common functionality, you're
	    using several third-party plugins that live in the <tt class="docutils literal"><span class="pre">plugins/</span></tt> directory.
	    In other words, the code that drives your application lives in many different
	    places.</p>
	  <p>In Symfony2, life is much simpler because <em>all</em> Symfony2 code must live in
	    a bundle. In our pretend symfony1 project, all the code <em>could</em> be moved
	    into one or more plugins (which is a very good practice, in fact). Assuming
	    that all modules, PHP classes, schema, routing configuration, etc were moved
	    into a plugin, the symfony1 <tt class="docutils literal"><span class="pre">plugins/</span></tt> directory would be very similar
	    to the Symfony2 <tt class="docutils literal"><span class="pre">src/</span></tt> directory.</p>
	  <p>Put simply again, the <tt class="docutils literal"><span class="pre">src/</span></tt> directory is where your code, assets,
	    templates and most anything else specific to your project will live.</p>
	</div>
	<div class="section" id="the-vendor-directory">
	  <h3>The <tt class="docutils literal"><span class="pre">vendor/</span></tt> Directory<a class="headerlink" href="#the-vendor-directory" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><span class="pre">vendor/</span></tt> directory is basically equivalent to the <tt class="docutils literal"><span class="pre">lib/vendor/</span></tt>
	    directory in symfony1, which was the conventional directory for all vendor
	    libraries. By default, you'll find the Symfony2 library files in this directory,
	    along with several other dependent libraries such as Doctrine2, Twig and
	    Swiftmailer.</p>
	</div>
	<div class="section" id="the-web-directory">
	  <h3>The <tt class="docutils literal"><span class="pre">web/</span></tt> Directory<a class="headerlink" href="#the-web-directory" title="Permalink to this headline">¶</a></h3>
	  <p>Not much has changed in the <tt class="docutils literal"><span class="pre">web/</span></tt> directory. The most noticeable difference
	    is the absence of the <tt class="docutils literal"><span class="pre">css/</span></tt>, <tt class="docutils literal"><span class="pre">js/</span></tt> and <tt class="docutils literal"><span class="pre">images/</span></tt> directories. This
	    is intentional. Like with your PHP code, all assets should also live inside
	    a bundle. With the help of a console command, the <tt class="docutils literal"><span class="pre">Resources/public/</span></tt>
	    directory of each bundle is copied or symbolically-linked to the <tt class="docutils literal"><span class="pre">web/bundles/</span></tt>
	    directory. This allows you to keep assets organized inside your bundle, but
	    still make them available to the public. To make sure that all bundles are
	    available, run the following command:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="o">./</span><span class="nx">app</span><span class="o">/</span><span class="nx">console_dev</span> <span class="nx">assets</span><span class="o">:</span><span class="nx">install</span> <span class="nx">web</span> <span class="o">--</span><span class="nb">symlink</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">This command is the Symfony2 equivalent to the symfony1 <tt class="docutils literal"><span class="pre">plugin:publish-assets</span></tt>
		command.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="autoloading">
	<h2>Autoloading<a class="headerlink" href="#autoloading" title="Permalink to this headline">¶</a></h2>
	<p>One of the advantageous of modern frameworks is never needing to worry about
	  requiring files. By making use of an autoloader, you can refer to any class
	  in your project and trust that it's available. This is made possible via an
	  autoloader. Autoloading has changed in Symfony2 to be more universal, faster,
	  and independent of needing to clear your cache.</p>
	<p>In symfony1, autoloading was done by searching the entire project for the
	  presence of PHP class files and caching this information in a giant array.
	  That array told symfony1 exactly which file contained each class. In the
	  production environment, this caused you to need to clear the cache when classes
	  were added or moved.</p>
	<p>In Symfony2, a new class - <tt class="docutils literal"><span class="pre">UniversalClassLoader</span></tt> - handles this process.
	  The idea behind the autoloader is simple: the name of your class (including
	  the namespace) must match up with the path to the file containing that class.
	  Take the <tt class="docutils literal"><span class="pre">HelloController</span></tt> from the Symfony2 Standard Edition as an example:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\DemoBundle\Controller</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">DemoController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
	  </pre></div>
	</div>
	<p>The file itself lives at <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Controller/DemoController.php</span></tt>.
	  As you can see, the location of the file follows the namespace of the class.
	  Specifically, the namespace, <tt class="docutils literal"><span class="pre">Acme\DemoBundle\Controller</span></tt>, spells out
	  the directory that the file should live in (<tt class="docutils literal"><span class="pre">src\Acme\DemoController\Controller</span></tt>).
	  This is because, in the <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt> file, you'll configure Symfony
	  to look for the <tt class="docutils literal"><span class="pre">Acme</span></tt> namespace in the <tt class="docutils literal"><span class="pre">src</span></tt> directory:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/autoload.php</span>

<span class="c1">// ...</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'Acme'</span>             <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../src'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>If the file did <em>not</em> live at this exact location, you'd receive a
	  <tt class="docutils literal"><span class="pre">Class</span> <span class="pre">"Acme\DemoBundle\Controller\DemoController"</span> <span class="pre">does</span> <span class="pre">not</span> <span class="pre">exist.</span></tt>
	  error. In Symfony2, a "class does not exist" means that the suspect class
	  namespace and physical location do not match. Basically, Symfony2 is looking
	  in one exact location for that class, but that location doesn't exist (or
	  contains a different class). In order for a class to be autoloaded, you
	  <strong>never need to clear your cache</strong> in Symfony2.</p>
	<p>As mentioned before, for the autoloader to work, it needs to know that the
	  <tt class="docutils literal"><span class="pre">Acme</span></tt> namespace lives in the <tt class="docutils literal"><span class="pre">src</span></tt> directory and that, for example,
	  the <tt class="docutils literal"><span class="pre">Doctrine</span></tt> namespace lives in the <tt class="docutils literal"><span class="pre">vendor/doctrine/lib/</span></tt> directory.
	  This mapping is entirely controlled by you via the <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt> file.</p>
      </div>
      <div class="section" id="using-the-console">
	<h2>Using the Console<a class="headerlink" href="#using-the-console" title="Permalink to this headline">¶</a></h2>
	<p>In symfony1, the console is in the root directory of your project and is
	  called <tt class="docutils literal"><span class="pre">symfony</span></tt>:</p>
	<div class="highlight-text"><div class="highlight"><pre>php symfony
	  </pre></div>
	</div>
	<p>In Symfony2, the console is now in the app sub-directory and is called
	  <tt class="docutils literal"><span class="pre">console</span></tt>:</p>
	<div class="highlight-text"><div class="highlight"><pre>php app/console
	  </pre></div>
	</div>
      </div>
      <div class="section" id="applications">
	<h2>Applications<a class="headerlink" href="#applications" title="Permalink to this headline">¶</a></h2>
	<p>In a symfony1 project, it is common to have several applications: one for the
	  frontend and one for the backend for instance.</p>
	<p>In a Symfony2 project, you only need to create one application (a blog
	  application, an intranet application, ...). Most of the time, if you want to
	  create a second application, you might instead create another project and
	  share some bundles between them.</p>
	<p>And if you need to separate the frontend and the backend features of some
	  bundles, you can create sub-namespaces for controllers, sub-directories for
	  templates, different semantic configurations, separate routing configurations,
	  and so on.</p>
	<p>Of course, there's nothing wrong with having multiple applications in your
	  project, that's entirely up to you. A second application would mean a new
	  directory, e.g. <tt class="docutils literal"><span class="pre">my_app/</span></tt>, with the same basic setup as the <tt class="docutils literal"><span class="pre">app/</span></tt> directory.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Read the definition of a <a class="reference internal" href="../glossary.html#term-project"><em class="xref std std-term">Project</em></a>, an <a class="reference internal" href="../glossary.html#term-application"><em class="xref std std-term">Application</em></a>, and a
	      <a class="reference internal" href="../glossary.html#term-bundle"><em class="xref std std-term">Bundle</em></a> in the glossary.</p>
	</div></div>
      </div>
      <div class="section" id="bundles-and-plugins">
	<h2>Bundles and Plugins<a class="headerlink" href="#bundles-and-plugins" title="Permalink to this headline">¶</a></h2>
	<p>In a symfony1 project, a plugin could contain configuration, modules, PHP
	  libraries, assets and anything else related to your project. In Symfony2,
	  the idea of a plugin is replaced by the "bundle". A bundle is even more powerful
	  than a plugin because the core Symfony2 framework is brought in via a series
	  of bundles. In Symfony2, bundles are first-class citizens that are so flexible
	  that even core code itself is a bundle.</p>
	<p>In symfony1, a plugin must be enabled inside the <tt class="docutils literal"><span class="pre">ProjectConfiguration</span></tt>
	  class:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// config/ProjectConfiguration.class.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">setup</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">enableAllPluginsExcept</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="cm">/* some plugins here */</span><span class="p">));</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In Symfony2, the bundles are activated inside the application kernel:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\FrameworkBundle\FrameworkBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\TwigBundle\TwigBundle</span><span class="p">(),</span>
        <span class="c1">// ...</span>
        <span class="k">new</span> <span class="nx">Acme\DemoBundle\AcmeDemoBundle</span><span class="p">(),</span>
    <span class="p">);</span>

    <span class="k">return</span> <span class="nv">$bundles</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>You also need to be sure that the <tt class="docutils literal"><span class="pre">Acme</span></tt> namespace is set to be autoloaded:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/autoload.php</span>
<span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">UniversalClassLoader</span><span class="p">();</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Symfony'</span>                        <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/symfony/src'</span><span class="p">,</span>
    <span class="s1">'Acme'</span>                           <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../src'</span><span class="p">,</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<div class="section" id="routing-routing-yml-and-configration-config-yml">
	  <h3>Routing (<tt class="docutils literal"><span class="pre">routing.yml</span></tt>) and Configration (<tt class="docutils literal"><span class="pre">config.yml</span></tt>)<a class="headerlink" href="#routing-routing-yml-and-configration-config-yml" title="Permalink to this headline">¶</a></h3>
	  <p>In symfony1, the <tt class="docutils literal"><span class="pre">routing.yml</span></tt> and <tt class="docutils literal"><span class="pre">app.yml</span></tt> configuration files were
	    automatically loaded inside any plugin. In Symfony2, routing and application
	    configuration inside a bundle must be included manually. For example, to
	    include a routing resource from a bundle called <tt class="docutils literal"><span class="pre">AcmeDemoBundle</span></tt>, you can
	    do the following:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="nx">_hello</span><span class="o">:</span>
    <span class="nx">resource</span><span class="o">:</span> <span class="s2">"@AcmeDemoBundle/Resources/config/routing.yml"</span>
	    </pre></div>
	  </div>
	  <p>This will load the routes found in the <tt class="docutils literal"><span class="pre">Resources/config/routing.yml</span></tt> file
	    of the <tt class="docutils literal"><span class="pre">AcmeDemoBundle</span></tt>. The special <tt class="docutils literal"><span class="pre">@AcmeDemoBundle</span></tt> is a shortcut syntax
	    that, internally, resolves to the full path to that bundle.</p>
	  <p>You can use this same strategy to bring in configuration from a bundle:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="s">"@AcmeDemoBundle/Resources/config/config.yml"</span> <span class="p-Indicator">}</span>
	    </pre></div>
	  </div>
	  <p>In Symfony2, configuration is a bit like <tt class="docutils literal"><span class="pre">app.yml</span></tt> in symfony1, exact much
	    more systematic. With <tt class="docutils literal"><span class="pre">app.yml</span></tt>, you could simply create any keys you wanted.
	    By default, these entries were meaningless and depended entirely on how you
	    used them in your application:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># some app.yml file from symfony1</span>
<span class="l-Scalar-Plain">all</span><span class="p-Indicator">:</span>
  <span class="l-Scalar-Plain">email</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">from_address</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">foo.bar@example.com</span>
	    </pre></div>
	  </div>
	  <p>In Symfony2, you can also create arbitrary entries under the <tt class="docutils literal"><span class="pre">parameters</span></tt>
	    key of your configuration:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">parameters</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">email.from_address</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">foo.bar@example.com</span>
	    </pre></div>
	  </div>
	  <p>You can now access this from a controller, for example:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$fromAddress</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">container</span><span class="o">-&gt;</span><span class="na">getParameter</span><span class="p">(</span><span class="s1">'email.from_address'</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>In reality, the Symfony2 configuration is much more powerful and is used
	    primarily to configure objects that you can use. For more information, see
	    the chapter titled "<a class="reference internal" href="../book/service_container.html"><em>Service Container</em></a>".</p>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to create a custom Data Collector" href="profiler/data_collector.html">
      «&nbsp;How to create a custom Data Collector
    </a><span class="separator">|</span>
    <a accesskey="N" title="Reference Documents" href="../reference/index.html">
      Reference Documents&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
