<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to Master and Create new Environments</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-master-and-create-new-environments">
      <span id="index-0"></span><h1>How to Master and Create new Environments<a class="headerlink" href="#how-to-master-and-create-new-environments" title="Permalink to this headline">¶</a></h1>
      <p>Every application is the combination of code and a set of configuration that
	dictates how that code should function. The configuration may define the
	database being used, whether or not something should be cached, or how verbose
	logging should be. In Symfony2, the idea of "environments" is the idea that
	the same codebase can be run using multiple different configurations. For
	example, the <tt class="docutils literal"><span class="pre">dev</span></tt> environment should use configuration that makes development
	easy and friendly, while the <tt class="docutils literal"><span class="pre">prod</span></tt> environment should use a set of configuration
	optimized for speed.</p>
      <div class="section" id="different-environments-different-configuration-files">
	<span id="index-1"></span><h2>Different Environments, Different Configuration Files<a class="headerlink" href="#different-environments-different-configuration-files" title="Permalink to this headline">¶</a></h2>
	<p>A typical Symfony2 application begins with three environments: <tt class="docutils literal"><span class="pre">dev</span></tt>,
	  <tt class="docutils literal"><span class="pre">prod</span></tt>, and <tt class="docutils literal"><span class="pre">test</span></tt>. As discussed, each "environment" simply represents
	  a way to execute the same codebase with different configuration. It should
	  be no surprise then that each environment loads its own individual configuration
	  file. If you're using the YAML configuration format, the following files
	  are used:</p>
	<blockquote>
	  <div><ul class="simple">
	      <li>for the <tt class="docutils literal"><span class="pre">dev</span></tt> environment: <tt class="docutils literal"><span class="pre">app/config/config_dev.yml</span></tt></li>
	      <li>for the <tt class="docutils literal"><span class="pre">prod</span></tt> environment: <tt class="docutils literal"><span class="pre">app/config/config_prod.yml</span></tt></li>
	      <li>for the <tt class="docutils literal"><span class="pre">test</span></tt> environment: <tt class="docutils literal"><span class="pre">app/config/config_test.yml</span></tt></li>
	    </ul>
	</div></blockquote>
	<p>This works via a simple standard that's used by default inside the <tt class="docutils literal"><span class="pre">AppKernel</span></tt>
	  class:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="c1">// ...</span>

<span class="k">class</span> <span class="nc">AppKernel</span> <span class="k">extends</span> <span class="nx">Kernel</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">registerContainerConfiguration</span><span class="p">(</span><span class="nx">LoaderInterface</span> <span class="nv">$loader</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">load</span><span class="p">(</span><span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/config/config_'</span><span class="o">.</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getEnvironment</span><span class="p">()</span><span class="o">.</span><span class="s1">'.yml'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>As you can see, when Symfony2 is loaded, it uses the given environment to
	  determine which configuration file to load. This accomplishes the goal of
	  multiple environments in an elegant, powerful and transparent way.</p>
	<p>Of course, in reality, each environment differs only somewhat from others.
	  Generally, all environments will share a large base of common configuration.
	  Opening the "dev" configuration file,  you can see how this is accomplished
	  easily and transparently:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="nv">config.yml</span> <span class="p-Indicator">}</span>

<span class="c1"># ...</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;imports&gt;</span>
    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"config.xml"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/imports&gt;</span>

<span class="c">&lt;!-- ... --&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'config.php'</span><span class="p">);</span>

<span class="c1">// ...</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>To share common configuration, each environment's configuration file
	  simply first imports from a central configuration file (<tt class="docutils literal"><span class="pre">config.yml</span></tt>).
	  The remainder of the file can then deviate from the default configuration
	  by overriding individual parameters. For example, by default, the <tt class="docutils literal"><span class="pre">web_profiler</span></tt>
	  toolbar is disabled. However, in the <tt class="docutils literal"><span class="pre">dev</span></tt> environment, the toolbar is
	  activated by modifying the default value in the <tt class="docutils literal"><span class="pre">dev</span></tt> configuration file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 184px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config_dev.yml</span>
<span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="nv">config.yml</span> <span class="p-Indicator">}</span>

<span class="l-Scalar-Plain">web_profiler</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">toolbar</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="c1"># ...</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- app/config/config_dev.xml --&gt;
&lt;imports&gt;
    &lt;import resource="config.xml" /&gt;
&lt;/imports&gt;

&lt;webprofiler:config
    toolbar="true"
    # ...
		  /&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config_dev.php</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'config.php'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'web_profiler'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'toolbar'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="c1">// ..</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="executing-an-application-in-different-environments">
	<span id="index-2"></span><h2>Executing an Application in Different Environments<a class="headerlink" href="#executing-an-application-in-different-environments" title="Permalink to this headline">¶</a></h2>
	<p>To execute the application in each environment, load up the application using
	  either the <tt class="docutils literal"><span class="pre">app.php</span></tt> (for the <tt class="docutils literal"><span class="pre">prod</span></tt> environment) or the <tt class="docutils literal"><span class="pre">app_dev.php</span></tt>
	  (for the <tt class="docutils literal"><span class="pre">dev</span></tt> environment) front controller:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/app.php      -&gt; *prod* environment
http://localhost/app_dev.php  -&gt; *dev* environment
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The given URLs assume that your web server is configured to use the <tt class="docutils literal"><span class="pre">web/</span></tt>
	      directory of the application as its root. Read more in
	      <a class="reference internal" href="../../book/installation.html"><em>Installing Symfony2</em></a>.</p>
	</div></div>
	<p>If you open up one of these files, you'll quickly see that the environment
	  used by each is explicitly set:</p>
	<div class="highlight-php"><table class="highlighttable"><tbody><tr><td class="linenos"><div class="linenodiv"><pre>1
2
3
4
5
6
7
8
		      9</pre></div></td><td class="code"><div class="highlight"><pre> <span class="o">&lt;?</span><span class="nx">php</span>

 <span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/bootstrap_cache.php'</span><span class="p">;</span>
 <span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppCache.php'</span><span class="p">;</span>

 <span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

 <span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppCache</span><span class="p">(</span><span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'prod'</span><span class="p">,</span> <span class="k">false</span><span class="p">));</span>
 <span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
		  </pre></div>
	</td></tr></tbody></table></div>
	<p>As you can see, the <tt class="docutils literal"><span class="pre">prod</span></tt> key specifies that this environment will run
	  in the <tt class="docutils literal"><span class="pre">prod</span></tt> environment. A Symfony2 application can be executed in any
	  environment by using this code and changing the environment string.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">test</span></tt> environment is used when writing functional tests and is
	      not accessible in the browser directly via a front controller. In other
	      words, unlike the other environments, there is no <tt class="docutils literal"><span class="pre">app_test.php</span></tt> front
	      controller file.</p>
	</div></div>
	<div class="admonition-wrapper" id="index-3">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title"><em>Debug</em> Mode</p>
	    <p>Important, but unrelated to the topic of <em>environments</em> is the <tt class="docutils literal"><span class="pre">false</span></tt>
	      key on line 8 of the front controller above. This specifies whether or
	      not the application should run in "debug mode". Regardless of the environment,
	      a Symfony2 application can be run with debug mode set to <tt class="docutils literal"><span class="pre">true</span></tt> or
	      <tt class="docutils literal"><span class="pre">false</span></tt>. This affects many things in the application, such as whether
	      or not errors should be displayed or if cache files are dynamically rebuilt
	      on each request. Though not a requirement, debug mode is generally set
	      to <tt class="docutils literal"><span class="pre">true</span></tt> for the <tt class="docutils literal"><span class="pre">dev</span></tt> and <tt class="docutils literal"><span class="pre">test</span></tt> environments and <tt class="docutils literal"><span class="pre">false</span></tt> for
	      the <tt class="docutils literal"><span class="pre">prod</span></tt> environment.</p>
	    <p>Internally, the value of the debug mode becomes the <tt class="docutils literal"><span class="pre">kernel.debug</span></tt>
	      parameter used inside the <a class="reference internal" href="../../book/service_container.html"><em>service container</em></a>.
	      If you look inside the application configuration file, you'll see the
	      parameter used, for example, to turn logging on or off when using the
	      Doctrine DBAL:</p>
	    <div class="last configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 130px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>doctrine:
   dbal:
       logging:  %kernel.debug%
		      # ...</pre>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;doctrine:dbal logging="%kernel.debug%" ... /&gt;</pre>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'dbal'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'logging'</span>  <span class="o">=&gt;</span> <span class="s1">'%kernel.debug%'</span><span class="p">,</span>
        <span class="c1">// ...</span>
    <span class="p">),</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	</div></div>
      </div>
      <div class="section" id="creating-a-new-environment">
	<span id="index-4"></span><h2>Creating a New Environment<a class="headerlink" href="#creating-a-new-environment" title="Permalink to this headline">¶</a></h2>
	<p>By default, a Symfony2 application has three environments that handle most
	  cases. Of course, since an environment is nothing more than a string that
	  corresponds to a set of configuration, creating a new environment is quite
	  easy.</p>
	<p>Suppose, for example, that before deployment, you need to benchmark your
	  application. One way to benchmark the application is to use near-production
	  settings, but with Symfony2's <tt class="docutils literal"><span class="pre">web_profiler</span></tt> enabled. This allows Symfony2
	  to record information about your application while benchmarking.</p>
	<p>The best way to accomplish this is via a new environment called, for example,
	  <tt class="docutils literal"><span class="pre">benchmark</span></tt>. Start by creating a new configuration file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 184px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config_benchmark.yml</span>

<span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="nv">config_prod.yml</span> <span class="p-Indicator">}</span>

<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">profiler</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">only_exceptions</span><span class="p-Indicator">:</span> <span class="nv">false</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config_benchmark.xml --&gt;</span>

<span class="nt">&lt;imports&gt;</span>
    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"config_prod.xml"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/imports&gt;</span>

<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:profiler</span> <span class="na">only-exceptions=</span><span class="s">"false"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config_benchmark.php</span>

<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'config_prod.php'</span><span class="p">)</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'only-exceptions'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>And with this simple addition, the application now supports a new environment
	  called <tt class="docutils literal"><span class="pre">benchmark</span></tt>.</p>
	<p>This new configuration file imports the configuration from the <tt class="docutils literal"><span class="pre">prod</span></tt> environment
	  and modifies it. This guarantees that the new environment is identical to
	  the <tt class="docutils literal"><span class="pre">prod</span></tt> environment, except for any changes explicitly made here.</p>
	<p>Because you'll want this environment to be accessible via a browser, you
	  should also create a front controller for it. Copy the <tt class="docutils literal"><span class="pre">web/app.php</span></tt> file
	  to <tt class="docutils literal"><span class="pre">web/app_benchmark.php</span></tt> and edit the environment to be <tt class="docutils literal"><span class="pre">benchmark</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span>

<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/bootstrap.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppKernel.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'benchmark'</span><span class="p">,</span> <span class="k">false</span><span class="p">);</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>The new environment is now accessible via:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">http</span><span class="o">://</span><span class="nx">localhost</span><span class="o">/</span><span class="nx">app_benchmark</span><span class="o">.</span><span class="nx">php</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>Some environments, like the <tt class="docutils literal"><span class="pre">dev</span></tt> environment, are never meant to be
	      accessed on any deployed server by the general public. This is because
	      certain environments, for debugging purposes, may give too much information
	      about the application or underlying infrastructure. To be sure these environments
	      aren't accessible, the front controller is usually protected from external
	      IP addresses via the following code at the top of the controller:</p>
	    <blockquote class="last">
	      <div><div class="highlight-php"><div class="highlight"><pre><span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nb">in_array</span><span class="p">(</span><span class="o">@</span><span class="nv">$_SERVER</span><span class="p">[</span><span class="s1">'REMOTE_ADDR'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span><span class="s1">'127.0.0.1'</span><span class="p">,</span> <span class="s1">'::1'</span><span class="p">)))</span> <span class="p">{</span>
    <span class="k">die</span><span class="p">(</span><span class="s1">'You are not allowed to access this file. Check '</span><span class="o">.</span><span class="nb">basename</span><span class="p">(</span><span class="k">__FILE__</span><span class="p">)</span><span class="o">.</span><span class="s1">' for more information.'</span><span class="p">);</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	    </div></blockquote>
	</div></div>
      </div>
      <div class="section" id="environments-and-the-cache-directory">
	<span id="index-5"></span><h2>Environments and the Cache Directory<a class="headerlink" href="#environments-and-the-cache-directory" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2 takes advantage of caching in many ways: the application configuration,
	  routing configuration, Twig templates and more are cached to PHP objects
	  stored in files on the filesystem.</p>
	<p>By default, these cached files are largely stored in the <tt class="docutils literal"><span class="pre">app/cache</span></tt> directory.
	  However, each environment caches its own set of files:</p>
	<div class="highlight-text"><div class="highlight"><pre>app/cache/dev   - cache directory for the *dev* environment
app/cache/prod  - cache directory for the *prod* environment
	  </pre></div>
	</div>
	<p>Sometimes, when debugging, it may be helpful to inspect a cached file to
	  understand how something is working. When doing so, remember to look in
	  the directory of the environment you're using (most commonly <tt class="docutils literal"><span class="pre">dev</span></tt> while
	  developing and debugging). While it can vary, the <tt class="docutils literal"><span class="pre">app/cache/dev</span></tt> directory
	  includes the following:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">appDevDebugProjectContainer.php</span></tt> - the cached "service container" that
	    represents the cached application configuration;</li>
	  <li><tt class="docutils literal"><span class="pre">appdevUrlGenerator.php</span></tt> - the PHP class generated from the routing
	    configuration and used when generating URLs;</li>
	  <li><tt class="docutils literal"><span class="pre">appdevUrlMatcher.php</span></tt> - the PHP class used for route matching - look
	    here to see the compiled regular expression logic used to match incoming
	    URLs to different routes;</li>
	  <li><tt class="docutils literal"><span class="pre">twig/</span></tt> - this directory contains all the cached Twig templates.</li>
	</ul>
      </div>
      <div class="section" id="going-further">
	<h2>Going Further<a class="headerlink" href="#going-further" title="Permalink to this headline">¶</a></h2>
	<p>Read the article on <a class="reference internal" href="external_parameters.html"><em>How to Set External Parameters in the Service Container</em></a>.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to create a Custom Validation Constraint" href="../validation/custom_constraint.html">
      «&nbsp;How to create a Custom Validation Constraint
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to Set External Parameters in the Service Container" href="external_parameters.html">
      How to Set External Parameters in the Service Container&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
