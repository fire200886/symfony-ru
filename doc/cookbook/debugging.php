<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to optimize your development Environment for debugging</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-optimize-your-development-environment-for-debugging">
      <h1>How to optimize your development Environment for debugging<a class="headerlink" href="#how-to-optimize-your-development-environment-for-debugging" title="Permalink to this headline">¶</a></h1>
      <p>When you work on a Symfony project on your local machine, you should use the
	<tt class="docutils literal"><span class="pre">dev</span></tt> environment (<tt class="docutils literal"><span class="pre">app_dev.php</span></tt> front controller). This environment
	configuration is optimized for two main purposes:</p>
      <blockquote>
	<div><ul class="simple">
	    <li>Give the developer accurate feedback whenever something goes wrong (web
	      debug toolbar, nice exception pages, profiler, ...);</li>
	    <li>Be as similar as possible as the production environment to avoid problems
	      when deploying the project.</li>
	  </ul>
      </div></blockquote>
      <p>And to make the production environment as fast as possible, Symfony creates
	big PHP files in your cache containing the aggregation of PHP classes your
	project needs for every request. However, this behavior can confuse your IDE
	or your debugger. This recipe shows you how you can tweak this caching
	mechanism to make it friendlier when you need to debug code that involves
	Symfony classes.</p>
      <p>The <tt class="docutils literal"><span class="pre">app_dev.php</span></tt> front controller reads as follows by default:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="c1">// ...</span>

<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/bootstrap.php.cache'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppKernel.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'dev'</span><span class="p">,</span> <span class="k">true</span><span class="p">);</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">loadClassCache</span><span class="p">();</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	</pre></div>
      </div>
      <p>To make you debugger happier, disable all PHP class caches by removing the
	call to <tt class="docutils literal"><span class="pre">loadClassCache()</span></tt> and by replacing the require statements like
	below:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="c1">// ...</span>

<span class="c1">// require_once __DIR__.'/../app/bootstrap.php.cache';</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/autoload.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppKernel.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'dev'</span><span class="p">,</span> <span class="k">true</span><span class="p">);</span>
<span class="c1">// $kernel-&gt;loadClassCache();</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	</pre></div>
      </div>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">If you disable the PHP caches, don't forget to revert after your debugging
	    session.</p>
      </div></div>
      <p>Some IDEs do not like the fact that some classes are stored in different
	locations. To avoid problems, you can either tell your IDE to ignore the PHP
	cache files, or you can change the extension used by Symfony for these files:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">loadClassCache</span><span class="p">(</span><span class="s1">'classes'</span><span class="p">,</span> <span class="s1">'.php.cache'</span><span class="p">);</span>
	</pre></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to create Console/Command-Line Commands" href="console.html">
      «&nbsp;How to create Console/Command-Line Commands
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use Monolog to write Logs" href="logging/monolog.html">
      How to use Monolog to write Logs&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
