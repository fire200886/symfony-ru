<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to expose a Semantic Configuration for a Bundle</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-expose-a-semantic-configuration-for-a-bundle">
      <span id="index-0"></span><h1>How to expose a Semantic Configuration for a Bundle<a class="headerlink" href="#how-to-expose-a-semantic-configuration-for-a-bundle" title="Permalink to this headline">¶</a></h1>
      <p>If you open your application configuration file (usually <tt class="docutils literal"><span class="pre">app/config/config.yml</span></tt>),
	you'll see a number of different configuration "namespaces", such as <tt class="docutils literal"><span class="pre">framework</span></tt>,
	<tt class="docutils literal"><span class="pre">twig</span></tt>, and <tt class="docutils literal"><span class="pre">doctrine</span></tt>. Each of these configures a specific bundle, allowing
	you to configure things at a high level and then let the bundle make all the
	low-level, complex changes that result.</p>
      <p>For example, the following tells the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> to enable the form
	integration, which involves the defining of quite a few services as well
	as integration of other related components:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 112px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">form</span><span class="p-Indicator">:</span>            <span class="l-Scalar-Plain">true</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:form</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'form'</span>            <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>When you create a bundle, you have two choices on how to handle configuration:</p>
      <ol class="arabic">
	<li><p class="first"><strong>Normal Service Configuration</strong> (<em>easy</em>):</p>
	  <blockquote>
	    <div><p>You can specify your services in a configuration file (e.g. <tt class="docutils literal"><span class="pre">services.yml</span></tt>)
		that lives in your bundle and then import it from your main application
		configuration. This is really easy, quick and totally effective. If you
		make use of <a class="reference internal" href="../../book/service_container.html#book-service-container-parameters"><em>parameters</em></a>, then
		you still have the flexibility to customize your bundle from your application
		configuration. See "<a class="reference internal" href="../../book/service_container.html#service-container-imports-directive"><em>Importing Configuration with imports</em></a>" for more
		details.</p>
	  </div></blockquote>
	</li>
	<li><p class="first"><strong>Exposing Semantic Configuration</strong> (<em>advanced</em>):</p>
	  <blockquote>
	    <div><p>This is the way configuration is done with the core bundles (as described
		above). The basic idea is that, instead of having the user override individual
		parameters, you let the user configure just a few, specifically created
		options. As the bundle developer, you then parse through that configuration
		and load services inside an "Extension" class. With this method, you won't
		need to import any configuration resources from your main application
		configuration: the Extension class can handle all of this.</p>
	  </div></blockquote>
	</li>
      </ol>
      <p>The second option - which you'll learn about in this article - is much more
	flexible, but also requires more time to setup. If you're wondering which
	method you should use, it's probably a good idea to start with method #1,
	and then change to #2 later if you need to.</p>
      <p>The second method has several specific advantages:</p>
      <ul class="simple">
	<li>Much more powerful than simply defining parameters: a specific option value
	  might trigger the creation of many service definitions;</li>
	<li>Ability to have configuration hierarchy</li>
	<li>Smart merging when several configuration files (e.g. <tt class="docutils literal"><span class="pre">config_dev.yml</span></tt>
	  and <tt class="docutils literal"><span class="pre">config.yml</span></tt>) override each other's configuration;</li>
	<li>Configuration validation (if you use a <a class="reference internal" href="#cookbook-bundles-extension-config-class"><em>Configuration Class</em></a>);</li>
	<li>IDE auto-completion when you create an XSD and developers use XML.</li>
      </ul>
      <div class="admonition-wrapper">
	<div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Overriding bundle parameters</p>
	  <p class="last">If a Bundle provides an Extension class, then you should generally <em>not</em>
	    override any service container parameters from that bundle. The idea
	    is that if an Extension class is present, every setting that should be
	    configurable should be present in the configuration made available by
	    that class. In other words the extension class defines all the publicly
	    supported configuration settings for which backward compatibility will
	    be maintained.</p>
      </div></div>
      <div class="section" id="creating-an-extension-class">
	<span id="index-1"></span><h2>Creating an Extension Class<a class="headerlink" href="#creating-an-extension-class" title="Permalink to this headline">¶</a></h2>
	<p>If you do choose to expose a semantic configuration for your bundle, you'll
	  first need to create a new "Extension" class, which will handle the process.
	  This class should live in the <tt class="docutils literal"><span class="pre">DependenyInjection</span></tt> directory of your bundle
	  and its name should be constructed by replacing the <tt class="docutils literal"><span class="pre">Bundle</span></tt> postfix of the
	  Bundle class name with <tt class="docutils literal"><span class="pre">Extension</span></tt>. For example, the Extension class of
	  <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> would be called <tt class="docutils literal"><span class="pre">AcmeHelloExtension</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// Acme/HelloBundle/DependencyInjection/HelloExtension.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\DependencyInjection\Extension</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\ContainerBuilder</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">AcmeHelloExtension</span> <span class="k">extends</span> <span class="nx">Extension</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="k">array</span> <span class="nv">$configs</span><span class="p">,</span> <span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// where all of the heavy logic is done</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getXsdValidationBasePath</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../Resources/config/'</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getNamespace</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="s1">'http://www.example.com/symfony/schema/'</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">getXsdValidationBasePath</span></tt> and <tt class="docutils literal"><span class="pre">getNamespace</span></tt> methods are only
	      required if the bundle provides optional XSD's for the configuration.</p>
	</div></div>
	<p>The presence of the previous class means that you can now define an <tt class="docutils literal"><span class="pre">acme_hello</span></tt>
	  configuration namespace in any configuration file. The namespace <tt class="docutils literal"><span class="pre">acme_hello</span></tt>
	  is constructed from the extension's class name by removing the word <tt class="docutils literal"><span class="pre">Extension</span></tt>
	  and then lowercasing and underscoring the rest of the name. In other words,
	  <tt class="docutils literal"><span class="pre">AcmeHelloExtension</span></tt> becomes <tt class="docutils literal"><span class="pre">acme_hello</span></tt>.</p>
	<p>You can begin specifying configuration under this namespace immediately:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 94px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">acme_hello</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" ?&gt;</span>

<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:acme_hello=</span><span class="s">"http://www.example.com/symfony/schema/"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://www.example.com/symfony/schema/ http://www.example.com/symfony/schema/hello-1.0.xsd"</span><span class="nt">&gt;</span>

   <span class="nt">&lt;acme_hello:config</span> <span class="nt">/&gt;</span>
   ...

<span class="nt">&lt;/container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'acme_hello'</span><span class="p">,</span> <span class="k">array</span><span class="p">());</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">If you follow the naming conventions laid out above, then the <tt class="docutils literal"><span class="pre">load()</span></tt>
	      method of your extension code is always called as long as your bundle
	      is registered in the Kernel. In other words, even if the user does not
	      provide any configuration (i.e. the <tt class="docutils literal"><span class="pre">acme_hello</span></tt> entry doesn't even
	      appear), the <tt class="docutils literal"><span class="pre">load()</span></tt> method will be called and passed an empty <tt class="docutils literal"><span class="pre">$configs</span></tt>
	      array. You can still provide some sensible defaults for your bundle if
	      you want.</p>
	</div></div>
      </div>
      <div class="section" id="parsing-the-configs-array">
	<h2>Parsing the <tt class="docutils literal"><span class="pre">$configs</span></tt> Array<a class="headerlink" href="#parsing-the-configs-array" title="Permalink to this headline">¶</a></h2>
	<p>Whenever a user includes the <tt class="docutils literal"><span class="pre">acme_hello</span></tt> namespace in a configuration file,
	  the configuration under it it is added to an array of configurations and
	  passed to the <tt class="docutils literal"><span class="pre">load()</span></tt> method of your extension (Symfony2 automatically
	  converts XML and YAML to an array).</p>
	<p>Take the following configuration:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">acme_hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">fooValue</span>
    <span class="l-Scalar-Plain">bar</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">barValue</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" ?&gt;</span>

<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:acme_hello=</span><span class="s">"http://www.example.com/symfony/schema/"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://www.example.com/symfony/schema/ http://www.example.com/symfony/schema/hello-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;acme_hello:config</span> <span class="na">foo=</span><span class="s">"fooValue"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;acme_hello:bar&gt;</span>barValue<span class="nt">&lt;/acme_hello:bar&gt;</span>
    <span class="nt">&lt;/acme_hello:config&gt;</span>

<span class="nt">&lt;/container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'acme_hello'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'fooValue'</span><span class="p">,</span>
    <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="s1">'barValue'</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The array passed to your <tt class="docutils literal"><span class="pre">load()</span></tt> method will look like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span>
        <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'fooValue'</span><span class="p">,</span>
        <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="s1">'barValue'</span><span class="p">,</span>
    <span class="p">)</span>
<span class="p">)</span>
	  </pre></div>
	</div>
	<p>Notice that this is an <em>array of arrays</em>, not just a single flat array of the
	  configuration values. This is intentional. For example, if <tt class="docutils literal"><span class="pre">acme_hello</span></tt>
	  appears in another configuration file - say <tt class="docutils literal"><span class="pre">config_dev.yml</span></tt> - with different
	  values beneath it, then the incoming array might look like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span>
        <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'fooValue'</span><span class="p">,</span>
        <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="s1">'barValue'</span><span class="p">,</span>
    <span class="p">),</span>
    <span class="k">array</span><span class="p">(</span>
        <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'fooDevValue'</span><span class="p">,</span>
        <span class="s1">'baz'</span> <span class="o">=&gt;</span> <span class="s1">'newConfigEntry'</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">)</span>
	  </pre></div>
	</div>
	<p>The order of the two arrays depends on which one is set first.</p>
	<p>It's your job, then, to decide how these configurations should be merged
	  together. You might, for example, have later values override previous values
	  or somehow merge them together.</p>
	<p>Later, in the <a class="reference internal" href="#cookbook-bundles-extension-config-class"><em>Configuration Class</em></a>
	  section, you'll learn of a truly robust way to handle this. But for now,
	  you might just merge them manually:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="k">array</span> <span class="nv">$configs</span><span class="p">,</span> <span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$config</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span>
    <span class="k">foreach</span> <span class="p">(</span><span class="nv">$configs</span> <span class="k">as</span> <span class="nv">$subConfig</span><span class="p">)</span> <span class="p">{</span>
        <span class="nv">$config</span> <span class="o">=</span> <span class="nb">array_merge</span><span class="p">(</span><span class="nv">$config</span><span class="p">,</span> <span class="nv">$subConfig</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="c1">// now use the flat $config array</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	    <p class="last">Make sure the above merging technique makes sense for your bundle. This
	      is just an example, and you should be careful to not use it blindly.</p>
	</div></div>
      </div>
      <div class="section" id="using-the-load-method">
	<h2>Using the <tt class="docutils literal"><span class="pre">load()</span></tt> Method<a class="headerlink" href="#using-the-load-method" title="Permalink to this headline">¶</a></h2>
	<p>Within <tt class="docutils literal"><span class="pre">load()</span></tt>, the <tt class="docutils literal"><span class="pre">$container</span></tt> variable refers to a container that only
	  knows about this namespace configuration (i.e. it doesn't contain service
	  information loaded from other bundles). The goal of the <tt class="docutils literal"><span class="pre">load()</span></tt> method
	  is to manipulate the container, adding and configuring any methods or services
	  needed by your bundle.</p>
	<div class="section" id="loading-external-configuration-resources">
	  <h3>Loading External Configuration Resources<a class="headerlink" href="#loading-external-configuration-resources" title="Permalink to this headline">¶</a></h3>
	  <p>One common thing to do is to load an external configuration file that may
	    contain the bulk of the services needed by your bundle. For example, suppose
	    you have a <tt class="docutils literal"><span class="pre">services.xml</span></tt> file that holds much of your bundle's service
	    configuration:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Loader\XmlFileLoader</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Config\FileLocator</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="k">array</span> <span class="nv">$configs</span><span class="p">,</span> <span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// prepare your $config variable</span>

    <span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">XmlFileLoader</span><span class="p">(</span><span class="nv">$container</span><span class="p">,</span> <span class="k">new</span> <span class="nx">FileLocator</span><span class="p">(</span><span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../Resources/config'</span><span class="p">));</span>
    <span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">load</span><span class="p">(</span><span class="s1">'services.xml'</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>You might even do this conditionally, based on one of the configuration values.
	    For example, suppose you only want to load a set of services if an <tt class="docutils literal"><span class="pre">enabled</span></tt>
	    option is passed and set to true:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="k">array</span> <span class="nv">$configs</span><span class="p">,</span> <span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// prepare your $config variable</span>

    <span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">XmlFileLoader</span><span class="p">(</span><span class="nv">$container</span><span class="p">,</span> <span class="k">new</span> <span class="nx">FileLocator</span><span class="p">(</span><span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../Resources/config'</span><span class="p">));</span>

    <span class="k">if</span> <span class="p">(</span><span class="nb">isset</span><span class="p">(</span><span class="nv">$config</span><span class="p">[</span><span class="s1">'enabled'</span><span class="p">])</span> <span class="o">&amp;&amp;</span> <span class="nv">$config</span><span class="p">[</span><span class="s1">'enabled'</span><span class="p">])</span> <span class="p">{</span>
        <span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">load</span><span class="p">(</span><span class="s1">'services.xml'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="configuring-services-and-setting-parameters">
	  <h3>Configuring Services and Setting Parameters<a class="headerlink" href="#configuring-services-and-setting-parameters" title="Permalink to this headline">¶</a></h3>
	  <p>Once you've loaded some service configuration, you may need to modify the
	    configuration based on some of the input values. For example, suppose you
	    have a service who's first argument is some string "type" that it will use
	    internally. You'd like this to be easily configured by the bundle user, so
	    in your service configuration file (e.g. <tt class="docutils literal"><span class="pre">services.xml</span></tt>), you define this
	    service and use a blank parameter - <tt class="docutils literal"><span class="pre">acme_hello.my_service_options</span></tt> - as
	    its first argument:</p>
	  <div class="highlight-xml"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;parameters&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"acme_hello.my_service_type"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/parameters&gt;</span>

    <span class="nt">&lt;services&gt;</span>
        <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"acme_hello.my_service"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\MyService"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;argument&gt;</span>%acme_hello.my_service_type%<span class="nt">&lt;/argument&gt;</span>
        <span class="nt">&lt;/service&gt;</span>
    <span class="nt">&lt;/services&gt;</span>
<span class="nt">&lt;/container&gt;</span>
	    </pre></div>
	  </div>
	  <p>But why would you define an empty parameter and then pass it to your service?
	    The answer is that you'll set this parameter in your extension class, based
	    on the incoming configuration values. Suppose, for example, that you want
	    to allow the user to define this <em>type</em> option under a key called <tt class="docutils literal"><span class="pre">my_type</span></tt>.
	    Add the following to the <tt class="docutils literal"><span class="pre">load()</span></tt> method to do this:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="k">array</span> <span class="nv">$configs</span><span class="p">,</span> <span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// prepare your $config variable</span>

    <span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">XmlFileLoader</span><span class="p">(</span><span class="nv">$container</span><span class="p">,</span> <span class="k">new</span> <span class="nx">FileLocator</span><span class="p">(</span><span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../Resources/config'</span><span class="p">));</span>
    <span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">load</span><span class="p">(</span><span class="s1">'services.xml'</span><span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nb">isset</span><span class="p">(</span><span class="nv">$config</span><span class="p">[</span><span class="s1">'my_type'</span><span class="p">]))</span> <span class="p">{</span>
        <span class="k">throw</span> <span class="k">new</span> <span class="nx">\InvalidArgumentException</span><span class="p">(</span><span class="s1">'The "my_type" option must be set'</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'acme_hello.my_service_type'</span><span class="p">,</span> <span class="nv">$config</span><span class="p">[</span><span class="s1">'my_type'</span><span class="p">]);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Now, the user can effectively configure the service by specifying the <tt class="docutils literal"><span class="pre">my_type</span></tt>
	    configuration value:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">acme_hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">my_type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">foo</span>
    <span class="c1"># ...</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" ?&gt;</span>

<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:acme_hello=</span><span class="s">"http://www.example.com/symfony/schema/"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://www.example.com/symfony/schema/ http://www.example.com/symfony/schema/hello-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;acme_hello:config</span> <span class="na">my_type=</span><span class="s">"foo"</span><span class="nt">&gt;</span>
        <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;/acme_hello:config&gt;</span>

<span class="nt">&lt;/container&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'acme_hello'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'my_type'</span> <span class="o">=&gt;</span> <span class="s1">'foo'</span><span class="p">,</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="global-parameters">
	  <h3>Global Parameters<a class="headerlink" href="#global-parameters" title="Permalink to this headline">¶</a></h3>
	  <p>When you're configuring the container, be aware that you have the following
	    global parameters available to use:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">kernel.name</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.environment</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.debug</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.root_dir</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.cache_dir</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.logs_dir</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.bundle_dirs</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.bundles</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">kernel.charset</span></tt></li>
	  </ul>
	  <div class="admonition-wrapper">
	    <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	      <p class="last">All parameter and service names starting with a <tt class="docutils literal"><span class="pre">_</span></tt> are reserved for the
		framework, and new ones must not be defined by bundles.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="validation-and-merging-with-a-configuration-class">
	<span id="cookbook-bundles-extension-config-class"></span><h2>Validation and Merging with a Configuration Class<a class="headerlink" href="#validation-and-merging-with-a-configuration-class" title="Permalink to this headline">¶</a></h2>
	<p>So far, you've done the merging of your configuration arrays by hand and
	  are checking for the presence of config values manually using the <tt class="docutils literal"><span class="pre">isset()</span></tt>
	  PHP function. An optional <em>Configuration</em> system is also available which
	  can help with merging, validation, default values, and format normalization.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Format normalization refers to the fact that certain formats - largely XML -
	      result in slightly different configuration arrays and that these arrays
	      need to be "normalized" to match everything else.</p>
	</div></div>
	<p>To take advantage of this system, you'll create a <tt class="docutils literal"><span class="pre">Configuration</span></tt> class
	  and build a tree that defines your configuration in that class:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/DependencyExtension/Configuration.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\DependencyInjection</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Config\Definition\Builder\TreeBuilder</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Config\Definition\ConfigurationInterface</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Configuration</span> <span class="k">implements</span> <span class="nx">ConfigurationInterface</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">getConfigTreeBuilder</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$treeBuilder</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">TreeBuilder</span><span class="p">();</span>
        <span class="nv">$rootNode</span> <span class="o">=</span> <span class="nv">$treeBuilder</span><span class="o">-&gt;</span><span class="na">root</span><span class="p">(</span><span class="s1">'acme_hello'</span><span class="p">);</span>

        <span class="nv">$rootNode</span>
            <span class="o">-&gt;</span><span class="na">children</span><span class="p">()</span>
                <span class="o">-&gt;</span><span class="na">scalarNode</span><span class="p">(</span><span class="s1">'my_type'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">defaultValue</span><span class="p">(</span><span class="s1">'bar'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">end</span><span class="p">()</span>
            <span class="o">-&gt;</span><span class="na">end</span><span class="p">()</span>
        <span class="p">;</span>

        <span class="k">return</span> <span class="nv">$treeBuilder</span><span class="p">;</span>
    <span class="p">}</span>
	  </pre></div>
	</div>
	<p>This is a <em>very</em> simple example, but you can now use this class in your <tt class="docutils literal"><span class="pre">load()</span></tt>
	  method to merge your configuration and force validation. If any options other
	  than <tt class="docutils literal"><span class="pre">my_type</span></tt> are passed, the user will be notified with an exception
	  that an unsupported option was passed:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Config\Definition\Processor</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">load</span><span class="p">(</span><span class="k">array</span> <span class="nv">$configs</span><span class="p">,</span> <span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$processor</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Processor</span><span class="p">();</span>
    <span class="nv">$configuration</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Configuration</span><span class="p">();</span>
    <span class="nv">$config</span> <span class="o">=</span> <span class="nv">$processor</span><span class="o">-&gt;</span><span class="na">processConfiguration</span><span class="p">(</span><span class="nv">$configuration</span><span class="p">,</span> <span class="nv">$configs</span><span class="p">);</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">processConfiguration()</span></tt> method uses the configuration tree you've defined
	  in the <tt class="docutils literal"><span class="pre">Configuration</span></tt> class and uses it to validate, normalize and merge
	  all of the configuration arrays together.</p>
	<p>The <tt class="docutils literal"><span class="pre">Configuration</span></tt> class can be much more complicated than shown here,
	  supporting array nodes, "prototype" nodes, advanced validation, XML-specific
	  normalization and advanced merging. The best way to see this in action is
	  to checkout out some of the core Configuration classes, such as the one from
	  the <a class="reference external" href="https://github.com/symfony/symfony/blob/master/src/Symfony/Bundle/FrameworkBundle/DependencyInjection/Configuration.php">FrameworkBundle Configuration</a> or the <a class="reference external" href="https://github.com/symfony/symfony/blob/master/src/Symfony/Bundle/TwigBundle/DependencyInjection/Configuration.php">TwigBundle Configuration</a>.</p>
      </div>
      <div class="section" id="extension-conventions">
	<span id="index-2"></span><h2>Extension Conventions<a class="headerlink" href="#extension-conventions" title="Permalink to this headline">¶</a></h2>
	<p>When creating an extension, follow these simple conventions:</p>
	<ul class="simple">
	  <li>The extension must be stored in the <tt class="docutils literal"><span class="pre">DependencyInjection</span></tt> sub-namespace;</li>
	  <li>The extension must be named after the bundle name and suffixed with
	    <tt class="docutils literal"><span class="pre">Extension</span></tt> (<tt class="docutils literal"><span class="pre">AcmeHelloExtension</span></tt> for <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>);</li>
	  <li>The extension should provide an XSD schema.</li>
	</ul>
	<p>If you follow these simple conventions, your extensions will be registered
	  automatically by Symfony2. If not, override the Bundle
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Bundle/Bundle.html#build()" title="Symfony\Component\HttpKernel\Bundle\Bundle::build()"><span class="pre">build()</span></a></tt> method in
	  your bundle:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Acme\HelloBundle\DependencyInjection\ExtensionHello</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">AcmeHelloBundle</span> <span class="k">extends</span> <span class="nx">Bundle</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">build</span><span class="p">(</span><span class="nx">ContainerBuilder</span> <span class="nv">$container</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">parent</span><span class="o">::</span><span class="na">build</span><span class="p">(</span><span class="nv">$container</span><span class="p">);</span>

        <span class="c1">// register extensions that do not follow the conventions manually</span>
        <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">registerExtension</span><span class="p">(</span><span class="k">new</span> <span class="nx">ExtensionHello</span><span class="p">());</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In this case, the extension class must also implement a <tt class="docutils literal"><span class="pre">getAlias()</span></tt> method
	  and return a unique alias named after the bundle (e.g. <tt class="docutils literal"><span class="pre">acme_hello</span></tt>). This
	  is required because the class name doesn't follow the standards by ending
	  in <tt class="docutils literal"><span class="pre">Extension</span></tt>.</p>
	<p>Additionally, the <tt class="docutils literal"><span class="pre">load()</span></tt> method of your extension will <em>only</em> be called
	  if the user specifies the <tt class="docutils literal"><span class="pre">acme_hello</span></tt> alias in at least one configuration
	  file. Once again, this is because the Extension class doesn't follow the
	  standards set out above, so nothing happens automatically.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use PdoSessionStorage to store Sessions in the Database" href="../configuration/pdo_session_storage.html">
      «&nbsp;How to use PdoSessionStorage to store Sessions in the Database
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to send an Email" href="../email.html">
      How to send an Email&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
