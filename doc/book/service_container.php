<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">The Service Container</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="the-service-container">
      <span id="index-0"></span><h1>The Service Container<a class="headerlink" href="#the-service-container" title="Permalink to this headline">¶</a></h1>
      <p>A modern PHP application is full of objects. One object may facilitate the
	delivery of email messages while another may allow you to persist information
	into a database. In your application, you may create an object that manages
	your product inventory, or another object that processes data from a third-party
	API. The point is that a modern application does many things and is organized
	into many objects that handle each task.</p>
      <p>In this chapter, we'll talk about a special PHP object in Symfony2 that helps
	you instantiate, organize and retrieve the many objects of your application.
	This object, called a service container, will allow you to standardize and
	centralize the way objects are constructed in your application. The container
	makes your life easier, is super fast, and emphasizes an architecture that
	promotes reusable and decoupled code. And since all core Symfony2 classes
	use the container, you'll learn how to extend, configure and use any object
	in Symfony2. In large part, the service container is the biggest contributor
	to the speed and extensibility of Symfony2.</p>
      <p>Finally, configuring and using the service container is easy. By the end
	of this chapter, you'll be comfortable creating your own objects via the
	container and customizing objects from any third-party bundle. You'll begin
	writing code that is more reusable, testable and decoupled, simply because
	the service container makes writing good code so easy.</p>
      <div class="section" id="what-is-a-service">
	<span id="index-1"></span><h2>What is a Service?<a class="headerlink" href="#what-is-a-service" title="Permalink to this headline">¶</a></h2>
	<p>Put simply, a <a class="reference internal" href="../glossary.html#term-service"><em class="xref std std-term">Service</em></a> is any PHP object that performs some sort of
	  "global" task. It's a purposefully-generic name used in computer science
	  to describe an object that's created for a specific purpose (e.g. delivering
	  emails). Each service is used throughout your application whenever you need
	  the specific functionality it provides. You don't have to do anything special
	  to make a service: simply write a PHP class with some code that accomplishes
	  a specific task. Congratulations, you've just created a service!</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">As a rule, a PHP object is a service if it is used globally in your
	      application. A single <tt class="docutils literal"><span class="pre">Mailer</span></tt> service is used globally to send
	      email messages whereas the many <tt class="docutils literal"><span class="pre">Message</span></tt> objects that it delivers
	      are <em>not</em> services. Similarly, a <tt class="docutils literal"><span class="pre">Product</span></tt> object is not a service,
	      but an object that persists <tt class="docutils literal"><span class="pre">Product</span></tt> objects to a database <em>is</em> a service.</p>
	</div></div>
	<p>So what's the big deal then? The advantage of thinking about "services" is
	  that you begin to think about separating each piece of functionality in your
	  application into a series of services. Since each service does just one job,
	  you can easily access each service and use its functionality wherever you
	  need it. Each service can also be more easily tested and configured since
	  it's separated from the other functionality in your application. This idea
	  is called <a class="reference external" href="http://wikipedia.org/wiki/Service-oriented_architecture">service-oriented architecture</a> and is not unique to Symfony2
	  or even PHP. Structuring your application around a set of independent service
	  classes is a well-known and trusted object-oriented best-practice. These skills
	  are key to being a good developer in almost any language.</p>
      </div>
      <div class="section" id="what-is-a-service-container">
	<span id="index-2"></span><h2>What is a Service Container?<a class="headerlink" href="#what-is-a-service-container" title="Permalink to this headline">¶</a></h2>
	<p>A <a class="reference internal" href="../glossary.html#term-service-container"><em class="xref std std-term">Service Container</em></a> (or <em>dependency injection container</em>) is simply
	  a PHP object that manages the instantiation of services (i.e. objects).
	  For example, suppose we have a simple PHP class that delivers email messages.
	  Without a service container, we must manually create the object whenever
	  we need it:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>

<span class="nv">$mailer</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Mailer</span><span class="p">(</span><span class="s1">'sendmail'</span><span class="p">);</span>
<span class="nv">$mailer</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">(</span><span class="s1">'ryan@foobar.net'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
	  </pre></div>
	</div>
	<p>This is easy enough. The imaginary <tt class="docutils literal"><span class="pre">Mailer</span></tt> class allows us to configure
	  the method used to deliver the email messages (e.g. <tt class="docutils literal"><span class="pre">sendmail</span></tt>, <tt class="docutils literal"><span class="pre">smtp</span></tt>, etc).
	  But what if we wanted to use the mailer service somewhere else? We certainly
	  don't want to repeat the mailer configuration <em>every</em> time we need to use
	  the <tt class="docutils literal"><span class="pre">Mailer</span></tt> object. What if we needed to change the <tt class="docutils literal"><span class="pre">transport</span></tt> from
	  <tt class="docutils literal"><span class="pre">sendmail</span></tt> to <tt class="docutils literal"><span class="pre">smtp</span></tt> everywhere in the application? We'd need to hunt
	  down every place we create a <tt class="docutils literal"><span class="pre">Mailer</span></tt> service and change it.</p>
      </div>
      <div class="section" id="creating-configuring-services-in-the-container">
	<span id="index-3"></span><h2>Creating/Configuring Services in the Container<a class="headerlink" href="#creating-configuring-services-in-the-container" title="Permalink to this headline">¶</a></h2>
	<p>A better answer is to let the service container create the <tt class="docutils literal"><span class="pre">Mailer</span></tt> object
	  for you. In order for this to work, we must <em>teach</em> the container how to
	  create the <tt class="docutils literal"><span class="pre">Mailer</span></tt> service. This is done via configuration, which can
	  be specified in YAML, XML or PHP:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">my_mailer</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span>        <span class="l-Scalar-Plain">Acme\HelloBundle\Mailer</span>
        <span class="l-Scalar-Plain">arguments</span><span class="p-Indicator">:</span>    <span class="p-Indicator">[</span><span class="nv">sendmail</span><span class="p-Indicator">]</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my_mailer"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Mailer"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument&gt;</span>sendmail<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'Acme\HelloBundle\Mailer'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'sendmail'</span><span class="p">)</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">When Symfony2 initializes, it builds the service container using the
	      application configuration (<tt class="docutils literal"><span class="pre">app/config/config.yml</span></tt> by default). The
	      exact file that's loaded is dictated by the <tt class="docutils literal"><span class="pre">AppKernel::loadConfig()</span></tt>
	      method, which loads an environment-specific configuration file (e.g.
	      <tt class="docutils literal"><span class="pre">config_dev.yml</span></tt> for the <tt class="docutils literal"><span class="pre">dev</span></tt> environment or <tt class="docutils literal"><span class="pre">config_prod.yml</span></tt>
	      for <tt class="docutils literal"><span class="pre">prod</span></tt>).</p>
	</div></div>
	<p>An instance of the <tt class="docutils literal"><span class="pre">Acme\HelloBundle\Mailer</span></tt> object is now available via
	  the service container. Since the container is available in any traditional
	  Symfony2 controller, we can easily access the new <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">HelloController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">sendEmailAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// ...</span>
        <span class="nv">$mailer</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">);</span>
        <span class="nv">$mailer</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">(</span><span class="s1">'ryan@foobar.net'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p>When using a traditional controller, there's an even shorter way to
	      access a service from the container. This is exactly equivalent to the
	      above method, but with less keystrokes:</p>
	    <div class="last highlight-php"><div class="highlight"><pre><span class="nv">$mailer</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">);</span>
	      </pre></div>
	    </div>
	</div></div>
	<p>When we ask for the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service from the container, the container
	  constructs the object and returns it. This is another major advantage of
	  using the service container. Namely, a service is <em>never</em> constructed until
	  it's needed. If you define a service and never use it on a request, the service
	  is never created. This saves memory and increases the speed of your application.
	  This also means that there's very little or no performance hit for defining
	  lots of services. Services that are never used are never constructed.</p>
	<p>As an added bonus, the <tt class="docutils literal"><span class="pre">Mailer</span></tt> service is only created once and the same
	  instance is returned each time you ask for the service. This is almost always
	  the behavior you'll need (it's more flexible and powerful), but we'll learn
	  later how you can configure a service that has multiple instances.</p>
      </div>
      <div class="section" id="service-parameters">
	<h2>Service Parameters<a class="headerlink" href="#service-parameters" title="Permalink to this headline">¶</a></h2>
	<p>The creation of new services (i.e. objects) via the container is pretty
	  straightforward. Parameters make defining services more organized and flexible:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 220px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/config.yml
parameters:
    my_mailer.class:      Acme\HelloBundle\Mailer
    my_mailer.transport:  sendmail

services:
    my_mailer:
        class:        %my_mailer.class%
		  arguments:    [%my_mailer.transport%]</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"my_mailer.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Mailer<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"my_mailer.transport"</span><span class="nt">&gt;</span>sendmail<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my_mailer"</span> <span class="na">class=</span><span class="s">"%my_mailer.class%"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument&gt;</span>%my_mailer.transport%<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'my_mailer.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mailer'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'my_mailer.transport'</span><span class="p">,</span> <span class="s1">'sendmail'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%my_mailer.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'%my_mailer.transport%'</span><span class="p">)</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The end result is exactly the same as before - the difference is only in
	  <em>how</em> we defined the service. By surrounding the <tt class="docutils literal"><span class="pre">my_mailer.class</span></tt> and
	  <tt class="docutils literal"><span class="pre">my_mailer.transport</span></tt> strings in percent (<tt class="docutils literal"><span class="pre">%</span></tt>) signs, the container knows
	  to look for parameters with those names. When the container is built, it
	  looks up the value of each parameter and uses it in the service definition.</p>
	<p>The purpose of parameters is to feed information into services. Of course
	  there was nothing wrong with defining the service without using any parameters.
	  Parameters, however, have several advantages:</p>
	<ul class="simple">
	  <li>separation and organization of all service "options" under a single
	    <tt class="docutils literal"><span class="pre">parameters</span></tt> key;</li>
	  <li>parameter values can be used in multiple service definitions;</li>
	  <li>when creating a service in a bundle (we'll show this shortly), using parameters
	    allows the service to be easily customized in your application.</li>
	</ul>
	<p>The choice of using or not using parameters is up to you. High-quality
	  third-party bundles will <em>always</em> use parameters as they make the service
	  stored in the container more configurable. For the services in your application,
	  however, you may not need the flexibility of parameters.</p>
      </div>
      <div class="section" id="importing-other-container-configuration-resources">
	<h2>Importing other Container Configuration Resources<a class="headerlink" href="#importing-other-container-configuration-resources" title="Permalink to this headline">¶</a></h2>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">In this section, we'll refer to service configuration files as <em>resources</em>.
	      This is to highlight that fact that, while most configuration resources
	      will be files (e.g. YAML, XML, PHP), Symfony2 is so flexible that configuration
	      could be loaded from anywhere (e.g. a database or even via an external
	      web service).</p>
	</div></div>
	<p>The service container is built using a single configuration resource
	  (<tt class="docutils literal"><span class="pre">app/config/config.yml</span></tt> by default). All other service configuration
	  (including the core Symfony2 and third-party bundle configuration) must
	  be imported from inside this file in one way or another. This gives you absolute
	  flexibility over the services in your application.</p>
	<p>External service configuration can be imported in two different ways. First,
	  we'll talk about the method that you'll use most commonly in your application:
	  the <tt class="docutils literal"><span class="pre">imports</span></tt> directive. In the following section, we'll introduce the
	  second method, which is the flexible and preferred method for importing service
	  configuration from third-party bundles.</p>
	<div class="section" id="importing-configuration-with-imports">
	  <span id="service-container-imports-directive"></span><span id="index-4"></span><h3>Importing Configuration with <tt class="docutils literal"><span class="pre">imports</span></tt><a class="headerlink" href="#importing-configuration-with-imports" title="Permalink to this headline">¶</a></h3>
	  <p>So far, we've placed our <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service container definition directly
	    in the application configuration file (e.g. <tt class="docutils literal"><span class="pre">app/config/config.yml</span></tt>). Of
	    course, since the <tt class="docutils literal"><span class="pre">Mailer</span></tt> class itself lives inside the <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>,
	    it makes more sense to put the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> container definition inside the
	    bundle as well.</p>
	  <p>First, move the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> container definition into a new container resource
	    file inside <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>. If the <tt class="docutils literal"><span class="pre">Resources</span></tt> or <tt class="docutils literal"><span class="pre">Resources/config</span></tt>
	    directories don't exist, create them.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 220px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    my_mailer.class:      Acme\HelloBundle\Mailer
    my_mailer.transport:  sendmail

services:
    my_mailer:
        class:        %my_mailer.class%
		    arguments:    [%my_mailer.transport%]</pre>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"my_mailer.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Mailer<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"my_mailer.transport"</span><span class="nt">&gt;</span>sendmail<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my_mailer"</span> <span class="na">class=</span><span class="s">"%my_mailer.class%"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument&gt;</span>%my_mailer.transport%<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'my_mailer.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mailer'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'my_mailer.transport'</span><span class="p">,</span> <span class="s1">'sendmail'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%my_mailer.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'%my_mailer.transport%'</span><span class="p">)</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The definition itself hasn't changed, only its location. Of course the service
	    container doesn't know about the new resource file. Fortunately, we can
	    easily import the resource file using the <tt class="docutils literal"><span class="pre">imports</span></tt> key in the application
	    configuration.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/config.yml
imports:
    hello_bundle:
		    resource: @AcmeHelloBundle/Resources/config/services.yml</pre>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;imports&gt;</span>
    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"@AcmeHelloBundle/Resources/config/services.xml"</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/imports&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'@AcmeHelloBundle/Resources/config/services.php'</span><span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">imports</span></tt> directive allows your application to include service container
	    configuration resources from any other location (most commonly from bundles).
	    The <tt class="docutils literal"><span class="pre">resource</span></tt> location, for files, is the absolute path to the resource
	    file. The special <tt class="docutils literal"><span class="pre">@AcmeHello</span></tt> syntax resolves the directory path of
	    the <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> bundle. This helps you specify the path to the resource
	    without worrying later if you move the <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> to a different
	    directory.</p>
	</div>
	<div class="section" id="importing-configuration-via-container-extensions">
	  <span id="service-container-extension-configuration"></span><span id="index-5"></span><h3>Importing Configuration via Container Extensions<a class="headerlink" href="#importing-configuration-via-container-extensions" title="Permalink to this headline">¶</a></h3>
	  <p>When developing in Symfony2, you'll most commonly use the <tt class="docutils literal"><span class="pre">imports</span></tt> directive
	    to import container configuration from the bundles you've created specifically
	    for your application. Third-party bundle container configuration, including
	    Symfony2 core services, are usually loaded using another method that's more
	    flexible and easy to configure in your application.</p>
	  <p>Here's how it works. Internally, each bundle defines its services very much
	    like we've seen so far. Namely, a bundle uses one or more configuration
	    resource files (usually XML) to specify the parameters and services for that
	    bundle. However, instead of importing each of these resources directly from
	    your application configuration using the <tt class="docutils literal"><span class="pre">imports</span></tt> directive, you can simply
	    invoke a <em>service container extension</em> inside the bundle that does the work for
	    you. A service container extension is a PHP class created by the bundle author
	    to accomplish two things:</p>
	  <ul class="simple">
	    <li>import all service container resources needed to configure the services for
	      the bundle;</li>
	    <li>provide semantic, straightforward configuration so that the bundle can
	      be configured without interacting with the flat parameters of the bundle's
	      service container configuration.</li>
	  </ul>
	  <p>In other words, a service container extension configures the services for
	    a bundle on your behalf. And as we'll see in a moment, the extension provides
	    a sensible, high-level interface for configuring the bundle.</p>
	  <p>Take the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> - the core Symfony2 framework bundle - as an
	    example. The presence of the following code in your application configuration
	    invokes the service container extension inside the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 220px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">secret</span><span class="p-Indicator">:</span>          <span class="l-Scalar-Plain">xxxxxxxxxx</span>
    <span class="l-Scalar-Plain">charset</span><span class="p-Indicator">:</span>         <span class="l-Scalar-Plain">UTF-8</span>
    <span class="l-Scalar-Plain">error_handler</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">null</span>
    <span class="l-Scalar-Plain">form</span><span class="p-Indicator">:</span>            <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">csrf_protection</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">router</span><span class="p-Indicator">:</span>        <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="s">"%kernel.root_dir%/config/routing.yml"</span> <span class="p-Indicator">}</span>
    <span class="c1"># ...</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config</span> <span class="na">charset=</span><span class="s">"UTF-8"</span> <span class="na">error-handler=</span><span class="s">"null"</span> <span class="na">secret=</span><span class="s">"xxxxxxxxxx"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;framework:form</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:csrf-protection</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:router</span> <span class="na">resource=</span><span class="s">"%kernel.root_dir%/config/routing.xml"</span> <span class="na">cache-warmer=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
<span class="nt">&lt;/framework&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'secret'</span>          <span class="o">=&gt;</span> <span class="s1">'xxxxxxxxxx'</span><span class="p">,</span>
    <span class="s1">'charset'</span>         <span class="o">=&gt;</span> <span class="s1">'UTF-8'</span><span class="p">,</span>
    <span class="s1">'error_handler'</span>   <span class="o">=&gt;</span> <span class="k">null</span><span class="p">,</span>
    <span class="s1">'form'</span>            <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
    <span class="s1">'csrf-protection'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
    <span class="s1">'router'</span>          <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'resource'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.root_dir%/config/routing.php'</span><span class="p">),</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>When the configuration is parsed, the container looks for an extension that
	    can handle the <tt class="docutils literal"><span class="pre">framework</span></tt> configuration directive. The extension in question,
	    which lives in the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>, is invoked and the service configuration
	    for the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> is loaded. If you remove the <tt class="docutils literal"><span class="pre">framework</span></tt> key
	    from your application configuration file entirely, the core Symfony2 services
	    won't be loaded. The point is that you're in control: the Symfony2 framework
	    doesn't contain any magic or perform any actions that you don't have control
	    over.</p>
	  <p>Of course you can do much more than simply "activate" the service container
	    extension of the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>. Each extension allows you to easily
	    customize the bundle, without worrying about how the internal services are
	    defined.</p>
	  <p>In this case, the extension allows you to customize the <tt class="docutils literal"><span class="pre">charset</span></tt>, <tt class="docutils literal"><span class="pre">error_handler</span></tt>,
	    <tt class="docutils literal"><span class="pre">csrf_protection</span></tt>, <tt class="docutils literal"><span class="pre">router</span></tt> configuration and much more. Internally,
	    the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> uses the options specified here to define and configure
	    the services specific to it. The bundle takes care of creating all the necessary
	    <tt class="docutils literal"><span class="pre">parameters</span></tt> and <tt class="docutils literal"><span class="pre">services</span></tt> for the service container, while still allowing
	    much of the configuration to be easily customized. As an added bonus, most
	    service container extensions are also smart enough to perform validation -
	    notifying you of options that are missing or the wrong data type.</p>
	  <p>When installing or configuring a bundle, see the bundle's documentation for
	    how the services for the bundle should be installed and configured. The options
	    available for the core bundles can be found inside the <a class="reference internal" href="../reference/index.html"><em>Reference Guide</em></a>.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Natively, the service container only recognizes the <tt class="docutils literal"><span class="pre">parameters</span></tt>,
		<tt class="docutils literal"><span class="pre">services</span></tt>, and <tt class="docutils literal"><span class="pre">imports</span></tt> directives. Any other directives
		are handled by a service container extension.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="referencing-injecting-services">
	<span id="index-6"></span><h2>Referencing (Injecting) Services<a class="headerlink" href="#referencing-injecting-services" title="Permalink to this headline">¶</a></h2>
	<p>So far, our original <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service is simple: it takes just one argument
	  in its constructor, which is easily configurable. As you'll see, the real
	  power of the container is realized when you need to create a service that
	  depends on one or more other services in the container.</p>
	<p>Let's start with an example. Suppose we have a new service, <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>,
	  that helps to manage the preparation and delivery of an email message to
	  a collection of addresses. Of course the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service is already
	  really good at delivering email messages, so we'll use it inside <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>
	  to handle the actual delivery of the messages. This pretend class might look
	  something like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$mailer</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">Mailer</span> <span class="nv">$mailer</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Without using the service container, we can create a new <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>
	  fairly easily from inside a controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">sendNewsletterAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$mailer</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">);</span>
    <span class="nv">$newsletter</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\HelloBundle\Newsletter\NewsletterManager</span><span class="p">(</span><span class="nv">$mailer</span><span class="p">);</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>This approach is fine, but what if we decide later that the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>
	  class needs a second or third constructor argument? What if we decide to
	  refactor our code and rename the class? In both cases, you'd need to find every
	  place where the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> is instantiated and modify it. Of course,
	  the service container gives us a much more appealing option:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 256px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Newsletter\NewsletterManager

services:
    my_mailer:
        # ...
    newsletter_manager:
        class:     %newsletter_manager.class%
		  arguments: [@my_mailer]</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;
&lt;parameters&gt;
    &lt;!-- ... --&gt;
    &lt;parameter key="newsletter_manager.class"&gt;Acme\HelloBundle\Newsletter\NewsletterManager&lt;/parameter&gt;
&lt;/parameters&gt;

&lt;services&gt;
    &lt;service id="my_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%"&gt;
        &lt;argument type="service" id="my_mailer"/&gt;
    &lt;/service&gt;
		  &lt;/services&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">))</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>In YAML, the special <tt class="docutils literal"><span class="pre">@my_mailer</span></tt> syntax tells the container to look for
	  a service named <tt class="docutils literal"><span class="pre">my_mailer</span></tt> and to pass that object into the constructor
	  of <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>. In this case, however, the specified service <tt class="docutils literal"><span class="pre">my_mailer</span></tt>
	  must exist. If it does not, an exception will be thrown. You can mark your
	  dependencies as optional - this will be discussed in the next section.</p>
	<p>Using references is a very powerful tool that allows you to create independent service
	  classes with well-defined dependencies. In this example, the <tt class="docutils literal"><span class="pre">newsletter_manager</span></tt>
	  service needs the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service in order to function. When you define
	  this dependency in the service container, the container takes care of all
	  the work of instantiating the objects.</p>
	<div class="section" id="optional-dependencies-setter-injection">
	  <h3>Optional Dependencies: Setter Injection<a class="headerlink" href="#optional-dependencies-setter-injection" title="Permalink to this headline">¶</a></h3>
	  <p>Injecting dependencies into the constructor in this manner is an excellent
	    way of ensuring that the dependency is available to use. If you have optional
	    dependencies for a class, then "setter injection" may be a better option. This
	    means injecting the dependency using a method call rather than through the
	    constructor. The class would look like this:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$mailer</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setMailer</span><span class="p">(</span><span class="nx">Mailer</span> <span class="nv">$mailer</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Injecting the dependency by the setter method just needs a change of syntax:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 274px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Newsletter\NewsletterManager

services:
    my_mailer:
        # ...
    newsletter_manager:
        class:     %newsletter_manager.class%
        calls:
		    - [ setMailer, [ @my_mailer ] ]</pre>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;
&lt;parameters&gt;
    &lt;!-- ... --&gt;
    &lt;parameter key="newsletter_manager.class"&gt;Acme\HelloBundle\Newsletter\NewsletterManager&lt;/parameter&gt;
&lt;/parameters&gt;

&lt;services&gt;
    &lt;service id="my_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%"&gt;
        &lt;call method="setMailer"&gt;
             &lt;argument type="service" id="my_mailer" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
		    &lt;/services&gt;</pre>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setMailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">)</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The approaches presented in this section are called "constructor injection"
		and "setter injection". The Symfony2 service container also supports
		"property injection".</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="making-references-optional">
	<h2>Making References Optional<a class="headerlink" href="#making-references-optional" title="Permalink to this headline">¶</a></h2>
	<p>Sometimes, one of your services may have an optional dependency, meaning
	  that the dependency is not required for your service to work properly. In
	  the example above, the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service <em>must</em> exist, otherwise an exception
	  will be thrown. By modifying the <tt class="docutils literal"><span class="pre">newsletter_manager</span></tt> service definition,
	  you can make this reference optional. The container will then inject it if
	  it exists and do nothing if it doesn't:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 202px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...

services:
    newsletter_manager:
        class:     %newsletter_manager.class%
		  arguments: [@?my_mailer]</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;

&lt;services&gt;
    &lt;service id="my_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%"&gt;
        &lt;argument type="service" id="my_mailer" on-invalid="ignore" /&gt;
    &lt;/service&gt;
		  &lt;/services&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\ContainerInterface</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="nx">ContainerInterface</span><span class="o">::</span><span class="na">IGNORE_ON_INVALID_REFERENCE</span><span class="p">))</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>In YAML, the special <tt class="docutils literal"><span class="pre">@?</span></tt> syntax tells the service container that the dependency
	  is optional. Of course, the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> must also be written to
	  allow for an optional dependency:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">Mailer</span> <span class="nv">$mailer</span> <span class="o">=</span> <span class="k">null</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="core-symfony-and-third-party-bundle-services">
	<h2>Core Symfony and Third-Party Bundle Services<a class="headerlink" href="#core-symfony-and-third-party-bundle-services" title="Permalink to this headline">¶</a></h2>
	<p>Since Symfony2 and all third-party bundles configure and retrieve their services
	  via the container, you can easily access them or even use them in your own
	  services. To keep things simple, Symfony2 by defaults does not require that
	  controllers be defined as services. Furthermore Symfony2 injects the entire
	  service container into your controller. For example, to handle the storage of
	  information on a user's session, Symfony2 provides a <tt class="docutils literal"><span class="pre">session</span></tt> service,
	  which you can access inside a standard controller as follows:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$bar</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$session</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'session'</span><span class="p">);</span>
    <span class="nv">$session</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">,</span> <span class="nv">$bar</span><span class="p">);</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In Symfony2, you'll constantly use services provided by the Symfony core or
	  other third-party bundles to perform tasks such as rendering templates (<tt class="docutils literal"><span class="pre">templating</span></tt>),
	  sending emails (<tt class="docutils literal"><span class="pre">mailer</span></tt>), or accessing information on the request (<tt class="docutils literal"><span class="pre">request</span></tt>).</p>
	<p>We can take this a step further by using these services inside services that
	  you've created for your application. Let's modify the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>
	  to use the real Symfony2 <tt class="docutils literal"><span class="pre">mailer</span></tt> service (instead of the pretend <tt class="docutils literal"><span class="pre">my_mailer</span></tt>).
	  Let's also pass the templating engine service to the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>
	  so that it can generate the email content via a template:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Templating\EngineInterface</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$mailer</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$templating</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">\Swift_Mailer</span> <span class="nv">$mailer</span><span class="p">,</span> <span class="nx">EngineInterface</span> <span class="nv">$templating</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">templating</span> <span class="o">=</span> <span class="nv">$templating</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Configuring the service container is easy:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>services:
    newsletter_manager:
        class:     %newsletter_manager.class%
		  arguments: [@mailer, @templating]</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_manager"</span> <span class="na">class=</span><span class="s">"%newsletter_manager.class%"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"mailer"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"templating"</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span>
        <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'mailer'</span><span class="p">),</span>
        <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'templating'</span><span class="p">)</span>
    <span class="p">)</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">newsletter_manager</span></tt> service now has access to the core <tt class="docutils literal"><span class="pre">mailer</span></tt>
	  and <tt class="docutils literal"><span class="pre">templating</span></tt> services. This is a common way to create services specific
	  to your application that leverage the power of different services within
	  the framework.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Be sure that <tt class="docutils literal"><span class="pre">swiftmailer</span></tt> entry appears in your application
	      configuration. As we mentioned in <a class="reference internal" href="#service-container-extension-configuration"><em>Importing Configuration via Container Extensions</em></a>,
	      the <tt class="docutils literal"><span class="pre">swiftmailer</span></tt> key invokes the service extension from the
	      <tt class="docutils literal"><span class="pre">SwiftmailerBundle</span></tt>, which registers the <tt class="docutils literal"><span class="pre">mailer</span></tt> service.</p>
	</div></div>
      </div>
      <div class="section" id="advanced-container-configuration">
	<span id="index-7"></span><h2>Advanced Container Configuration<a class="headerlink" href="#advanced-container-configuration" title="Permalink to this headline">¶</a></h2>
	<p>As we've seen, defining services inside the container is easy, generally
	  involving a <tt class="docutils literal"><span class="pre">service</span></tt> configuration key and a few parameters. However,
	  the container has several other tools available that help to <em>tag</em> services
	  for special functionality, create more complex services, and perform operations
	  after the container is built.</p>
	<div class="section" id="marking-services-as-public-private">
	  <h3>Marking Services as public / private<a class="headerlink" href="#marking-services-as-public-private" title="Permalink to this headline">¶</a></h3>
	  <p>When defining services, you'll usually want to be able to access these definitions
	    within your application code. These services are called <tt class="docutils literal"><span class="pre">public</span></tt>. For example,
	    the <tt class="docutils literal"><span class="pre">doctrine</span></tt> service registered with the container when using the DoctrineBundle
	    is a public service as you can access it via:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$doctrine</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>However, there are use-cases when you don't want a service to be public. This
	    is common when a service is only defined because it could be used as an
	    argument for another service.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If you use a private service as an argument to more than one other service,
		this will result in two different instances being used as the instantiation
		of the private service is done inline (e.g. <tt class="docutils literal"><span class="pre">new</span> <span class="pre">PrivateFooBar()</span></tt>).</p>
	  </div></div>
	  <p>Simply said: A service will be private when you do not want to access it
	    directly from your code.</p>
	  <p>Here is an example:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
   <span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span>
     <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\Foo</span>
     <span class="l-Scalar-Plain">public</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">false</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"foo"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Foo"</span> <span class="na">public=</span><span class="s">"false"</span> <span class="nt">/&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span><span class="s1">'Acme\HelloBundle\Foo'</span><span class="p">);</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">setPublic</span><span class="p">(</span><span class="k">false</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Now that the service is private, you <em>cannot</em> call:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>However, if a service has been marked as private, you can still alias it (see
	    below) to access this service (via the alias).</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Services are by default public.</p>
	  </div></div>
	</div>
	<div class="section" id="aliasing">
	  <h3>Aliasing<a class="headerlink" href="#aliasing" title="Permalink to this headline">¶</a></h3>
	  <p>When using core or third party bundles within your application, you may want
	    to use shortcuts to access some services. You can do so by aliasing them and,
	    furthermore, you can even alias non-public services.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
   <span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span>
     <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\Foo</span>
   <span class="l-Scalar-Plain">bar</span><span class="p-Indicator">:</span>
     <span class="l-Scalar-Plain">alias</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">foo</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"foo"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Foo"</span><span class="nt">/&gt;</span>

<span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"bar"</span> <span class="na">alias=</span><span class="s">"foo"</span> <span class="nt">/&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span><span class="s1">'Acme\HelloBundle\Foo'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>

<span class="nv">$containerBuilder</span><span class="o">-&gt;</span><span class="na">setAlias</span><span class="p">(</span><span class="s1">'bar'</span><span class="p">,</span> <span class="s1">'foo'</span><span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>This means that when using the container directly, you can access the <tt class="docutils literal"><span class="pre">foo</span></tt>
	    service by asking for the <tt class="docutils literal"><span class="pre">bar</span></tt> service like this:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'bar'</span><span class="p">);</span> <span class="c1">// Would return the foo service</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="requiring-files">
	  <h3>Requiring files<a class="headerlink" href="#requiring-files" title="Permalink to this headline">¶</a></h3>
	  <p>There might be use cases when you need to include another file just before
	    the service itself gets loaded. To do so, you can use the <tt class="docutils literal"><span class="pre">file</span></tt> directive.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>services:
   foo:
     class: Acme\HelloBundle\Foo\Bar
		    file: %kernel.root_dir%/src/path/to/file/foo.php</pre>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"foo"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Foo\Bar"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;file</span> <span class="na">name=</span><span class="s">"%kernel.root_dir%/src/path/to/file/foo.php"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span><span class="s1">'Acme\HelloBundle\Foo\Bar'</span><span class="p">);</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">setFile</span><span class="p">(</span><span class="s1">'%kernel.root_dir%/src/path/to/file/foo.php'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Notice that symfony will internally call the PHP function require_once
	    which means that your file will be included only once per request.</p>
	</div>
	<div class="section" id="tags-tags">
	  <h3>Tags (<tt class="docutils literal"><span class="pre">tags</span></tt>)<a class="headerlink" href="#tags-tags" title="Permalink to this headline">¶</a></h3>
	  <p>In the same way that a blog post on the Web might be tagged with things such
	    as "Symfony" or "PHP", services configured in your container can also be
	    tagged. In the service container, a tag implies that the service is meant
	    to be used for a specific purpose. Take the following example:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">foo.twig.extension</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\Extension\FooExtension</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span>  <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">twig.extension</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"foo.twig.extension"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Extension\RadiusExtension"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"twig.extension"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span><span class="s1">'Acme\HelloBundle\Extension\RadiusExtension'</span><span class="p">);</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'twig.extension'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'foo.twig.extension'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">twig.extension</span></tt> tag is a special tag that the <tt class="docutils literal"><span class="pre">TwigBundle</span></tt> uses
	    during configuration. By giving the service this <tt class="docutils literal"><span class="pre">twig.extension</span></tt> tag,
	    the bundle knows that the <tt class="docutils literal"><span class="pre">foo.twig.extension</span></tt> service should be registered
	    as a Twig extension with Twig. In other words, Twig finds all services tagged
	    with <tt class="docutils literal"><span class="pre">twig.extension</span></tt> and automatically registers them as extensions.</p>
	  <p>Tags, then, are a way to tell Symfony2 or other third-party bundles that
	    your service should be registered or used in some special way by the bundle.</p>
	  <p>The following is a list of tags available with the core Symfony2 bundles.
	    Each of these has a different effect on your service and many tags require
	    additional arguments (beyond just the <tt class="docutils literal"><span class="pre">name</span></tt> parameter).</p>
	  <ul class="simple">
	    <li>assetic.filter</li>
	    <li>assetic.templating.php</li>
	    <li>data_collector</li>
	    <li>form.field_factory.guesser</li>
	    <li>kernel.cache_warmer</li>
	    <li>kernel.listener</li>
	    <li>routing.loader</li>
	    <li>security.listener.factory</li>
	    <li>security.voter</li>
	    <li>templating.helper</li>
	    <li>twig.extension</li>
	    <li>translation.loader</li>
	    <li>validator.constraint_validator</li>
	    <li>zend.logger.writer</li>
	  </ul>
	</div>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/controller/service.html"><em>How to define Controllers as Services</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Bundles" href="bundles.html">
      «&nbsp;Bundles
    </a><span class="separator">|</span>
    <a accesskey="N" title="Symfony2 Internals" href="internals/index.html">
      Symfony2 Internals&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
