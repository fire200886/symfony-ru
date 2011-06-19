<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to autoload Classes</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-autoload-classes">
      <span id="index-0"></span><h1>How to autoload Classes<a class="headerlink" href="#how-to-autoload-classes" title="Permalink to this headline">¶</a></h1>
      <p>Whenever you use an undefined class, PHP uses the autoloading mechanism to
	delegate the loading of a file defining the class. Symfony2 provides a
	"universal" autoloader, which is able to load classes from files that implement
	one of the following conventions:</p>
      <ul class="simple">
	<li>The technical interoperability <a class="reference external" href="http://groups.google.com/group/php-standards/web/psr-0-final-proposal">standards</a> for PHP 5.3 namespaces and class
	  names;</li>
	<li>The <a class="reference external" href="http://pear.php.net/manual/en/standards.php">PEAR</a> naming convention for classes.</li>
      </ul>
      <p>If your classes and the third-party libraries you use for your project follow
	these standards, the Symfony2 autoloader is the only autoloader you will ever
	need.</p>
      <div class="section" id="usage">
	<h2>Usage<a class="headerlink" href="#usage" title="Permalink to this headline">¶</a></h2>
	<p>Registering the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/UniversalClassLoader.html" title="Symfony\Component\ClassLoader\UniversalClassLoader"><span class="pre">UniversalClassLoader</span></a></tt>
	  autoloader is straightforward:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">require_once</span> <span class="s1">'/path/to/src/Symfony/Component/ClassLoader/UniversalClassLoader.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\ClassLoader\UniversalClassLoader</span><span class="p">;</span>

<span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">UniversalClassLoader</span><span class="p">();</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">register</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>For minor performance gains class paths can be cached in memory using APC by
	  registering the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/ApcUniversalClassLoader.html" title="Symfony\Component\ClassLoader\ApcUniversalClassLoader"><span class="pre">ApcUniversalClassLoader</span></a></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">require_once</span> <span class="s1">'/path/to/src/Symfony/Component/ClassLoader/UniversalClassLoader.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="s1">'/path/to/src/Symfony/Component/ClassLoader/ApcUniversalClassLoader.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\ClassLoader\ApcUniversalClassLoader</span><span class="p">;</span>

<span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">ApcUniversalClassLoader</span><span class="p">(</span><span class="s1">'apc.prefix.'</span><span class="p">);</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">register</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>The autoloader is useful only if you add some libraries to autoload.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The autoloader is automatically registered in a Symfony2 application (see
	      <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt>).</p>
	</div></div>
	<p>If the classes to autoload use namespaces, use the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/UniversalClassLoader.html#registerNamespace()" title="Symfony\Component\ClassLoader\UniversalClassLoader::registerNamespace()"><span class="pre">registerNamespace()</span></a></tt>
	  or
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/UniversalClassLoader.html#registerNamespaces()" title="Symfony\Component\ClassLoader\UniversalClassLoader::registerNamespaces()"><span class="pre">registerNamespaces()</span></a></tt>
	  methods:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespace</span><span class="p">(</span><span class="s1">'Symfony'</span><span class="p">,</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/symfony/src'</span><span class="p">);</span>

<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Symfony'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/symfony/src'</span><span class="p">,</span>
    <span class="s1">'Monolog'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/monolog/src'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>For classes that follow the PEAR naming convention, use the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/UniversalClassLoader.html#registerPrefix()" title="Symfony\Component\ClassLoader\UniversalClassLoader::registerPrefix()"><span class="pre">registerPrefix()</span></a></tt>
	  or
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/UniversalClassLoader.html#registerPrefixes()" title="Symfony\Component\ClassLoader\UniversalClassLoader::registerPrefixes()"><span class="pre">registerPrefixes()</span></a></tt>
	  methods:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerPrefix</span><span class="p">(</span><span class="s1">'Twig_'</span><span class="p">,</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/twig/lib'</span><span class="p">);</span>

<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerPrefixes</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Swift_'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/swiftmailer/lib/classes'</span><span class="p">,</span>
    <span class="s1">'Twig_'</span>  <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/twig/lib'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Some libraries also require their root path be registered in the PHP
	      include path (<tt class="docutils literal"><span class="pre">set_include_path()</span></tt>).</p>
	</div></div>
	<p>Classes from a sub-namespace or a sub-hierarchy of PEAR classes can be looked
	  for in a location list to ease the vendoring of a sub-set of classes for large
	  projects:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Doctrine\\Common'</span>           <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/doctrine-common/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine\\DBAL\\Migrations'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/doctrine-migrations/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine\\DBAL'</span>             <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/doctrine-dbal/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine'</span>                   <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/vendor/doctrine/lib'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>In this example, if you try to use a class in the <tt class="docutils literal"><span class="pre">Doctrine\Common</span></tt> namespace
	  or one of its children, the autoloader will first look for the class under the
	  <tt class="docutils literal"><span class="pre">doctrine-common</span></tt> directory, and it will then fallback to the default
	  <tt class="docutils literal"><span class="pre">Doctrine</span></tt> directory (the last one configured) if not found, before giving up.
	  The order of the registrations is significant in this case.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use Varnish to speedup my Website" href="../cache/varnish.html">
      «&nbsp;How to use Varnish to speedup my Website
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to locate Files" href="finder.html">
      How to locate Files&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
