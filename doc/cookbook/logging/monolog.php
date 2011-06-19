<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to use Monolog to write Logs</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-monolog-to-write-logs">
      <span id="index-0"></span><h1>How to use Monolog to write Logs<a class="headerlink" href="#how-to-use-monolog-to-write-logs" title="Permalink to this headline">¶</a></h1>
      <p><a class="reference external" href="https://github.com/Seldaek/monolog">Monolog</a> is a logging library for PHP 5.3 used by Symfony2. It is
	inspired by the Python LogBook library.</p>
      <div class="section" id="usage">
	<h2>Usage<a class="headerlink" href="#usage" title="Permalink to this headline">¶</a></h2>
	<p>In Monolog each logger defines a logging channel. Each channel has a
	  stack of handlers to write the logs (the handlers can be shared).</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">When injecting the logger in a service you can
	      <a class="reference internal" href="../../reference/dic_tags.html#dic-tags-monolog"><em>use a custom channel</em></a> to see easily which
	      part of the application logged the message.</p>
	</div></div>
	<p>The basic handler is the <tt class="docutils literal"><span class="pre">StreamHandler</span></tt> which writes logs in a stream
	  (by default in the <tt class="docutils literal"><span class="pre">app/logs/prod.log</span></tt> in the prod environment and
	  <tt class="docutils literal"><span class="pre">app/logs/dev.log</span></tt> in the dev environment).</p>
	<p>Monolog comes also with a powerful built-in handler for the logging in
	  prod environment: <tt class="docutils literal"><span class="pre">FingersCrossedHandler</span></tt>. It allows you to store the
	  messages in a buffer and to log them only if a message reaches the
	  action level (ERROR in the configuration provided in the standard
	  edition) by forwarding the messages to another handler.</p>
	<p>To log a message simply get the logger service from the container in
	  your controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$logger</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'logger'</span><span class="p">);</span>
<span class="nv">$logger</span><span class="o">-&gt;</span><span class="na">info</span><span class="p">(</span><span class="s1">'We just go the logger'</span><span class="p">);</span>
<span class="nv">$logger</span><span class="o">-&gt;</span><span class="na">err</span><span class="p">(</span><span class="s1">'An error occurred'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Using only the methods of the
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/SymfonyComponentHttpKernelLogLoggerInterface.html" title="SymfonyComponentHttpKernelLogLoggerInterface"><span class="pre">SymfonyComponentHttpKernelLogLoggerInterface</span></a></tt> interface
	      allows to change the logger implementation without changing your code.</p>
	</div></div>
	<div class="section" id="using-several-handlers">
	  <h3>Using several handlers<a class="headerlink" href="#using-several-handlers" title="Permalink to this headline">¶</a></h3>
	  <p>The logger uses a stack of handlers which are called successively. This
	    allows you to log the messages in several ways easily.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 292px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">monolog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">handlers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">syslog</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">stream</span>
            <span class="l-Scalar-Plain">path</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">/var/log/symfony.log</span>
            <span class="l-Scalar-Plain">level</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">error</span>
        <span class="l-Scalar-Plain">main</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">fingerscrossed</span>
            <span class="l-Scalar-Plain">action_level</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">warning</span>
            <span class="l-Scalar-Plain">handler</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">file</span>
        <span class="l-Scalar-Plain">file</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">stream</span>
            <span class="l-Scalar-Plain">level</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">debug</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:monolog=</span><span class="s">"http://symfony.com/schema/dic/monolog"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd</span>
<span class="s">                        http://symfony.com/schema/dic/monolog http://symfony.com/schema/dic/monolog/monolog-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;monolog:config&gt;</span>
        <span class="nt">&lt;monolog:handler</span>
            <span class="na">name=</span><span class="s">"syslog"</span>
            <span class="na">type=</span><span class="s">"stream"</span>
            <span class="na">path=</span><span class="s">"/var/log/symfony.log"</span>
            <span class="na">level=</span><span class="s">"error"</span>
        <span class="nt">/&gt;</span>
        <span class="nt">&lt;monolog:handler</span>
            <span class="na">name=</span><span class="s">"main"</span>
            <span class="na">type=</span><span class="s">"fingerscrossed"</span>
            <span class="na">action-level=</span><span class="s">"warning"</span>
            <span class="na">handler=</span><span class="s">"file"</span>
        <span class="nt">/&gt;</span>
        <span class="nt">&lt;monolog:handler</span>
            <span class="na">name=</span><span class="s">"file"</span>
            <span class="na">type=</span><span class="s">"stream"</span>
            <span class="na">level=</span><span class="s">"debug"</span>
        <span class="nt">/&gt;</span>
    <span class="nt">&lt;/monolog:config&gt;</span>
<span class="nt">&lt;/container&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The above configuration defines a stack of handlers which will be called
	    in the order where they are defined.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The handler named "file" will not be included in the stack itself as
		it is used as a nested handler of the fingerscrossed handler.</p>
	  </div></div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If you want to change the config of MonologBundle in another config
		file you need to redefine the whole stack. It cannot be merged
		because the order matters and a merge does not allow to control the
		order.</p>
	  </div></div>
	</div>
	<div class="section" id="changing-the-formatter">
	  <h3>Changing the formatter<a class="headerlink" href="#changing-the-formatter" title="Permalink to this headline">¶</a></h3>
	  <p>The handler uses a <tt class="docutils literal"><span class="pre">Formatter</span></tt> to format the record before logging
	    it. All Monolog handlers use an instance of
	    <tt class="docutils literal"><span class="pre">Monolog\Formatter\LineFormatter</span></tt> by default but you can replace it
	    easily. Your formatter must implement
	    <tt class="docutils literal"><span class="pre">Monolog\Formatter\LineFormatterInterface</span></tt>.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 220px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">my_formatter</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Monolog\Formatter\JsonFormatter</span>
<span class="l-Scalar-Plain">monolog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">handlers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">file</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">stream</span>
            <span class="l-Scalar-Plain">level</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">debug</span>
            <span class="l-Scalar-Plain">formatter</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">my_formatter</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:monolog=</span><span class="s">"http://symfony.com/schema/dic/monolog"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd</span>
<span class="s">                        http://symfony.com/schema/dic/monolog http://symfony.com/schema/dic/monolog/monolog-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;services&gt;</span>
        <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my_formatter"</span> <span class="na">class=</span><span class="s">"Monolog\Formatter\JsonFormatter"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/services&gt;</span>
    <span class="nt">&lt;monolog:config&gt;</span>
        <span class="nt">&lt;monolog:handler</span>
            <span class="na">name=</span><span class="s">"file"</span>
            <span class="na">type=</span><span class="s">"stream"</span>
            <span class="na">level=</span><span class="s">"debug"</span>
            <span class="na">formatter=</span><span class="s">"my_formatter"</span>
        <span class="nt">/&gt;</span>
    <span class="nt">&lt;/monolog:config&gt;</span>
<span class="nt">&lt;/container&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
      </div>
      <div class="section" id="adding-some-extra-data-in-the-log-messages">
	<h2>Adding some extra data in the log messages<a class="headerlink" href="#adding-some-extra-data-in-the-log-messages" title="Permalink to this headline">¶</a></h2>
	<p>Monolog allows to process the record before logging it to add some
	  extra data. A processor can be applied for the whole handler stack or
	  only for a specific handler.</p>
	<p>A processor is simply a callable receiving the record as first argument
	  and a second argument which is either the logger or the handler
	  depending of the level where the processor is called.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 274px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>services:
    my_processor:
        class: Monolog\Processor\WebProcessor
monolog:
    handlers:
        file:
            type: stream
            level: debug
            processors:
                - Acme\MyBundle\MyProcessor::process
    processors:
		  - @my_processor</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:monolog="http://symfony.com/schema/dic/monolog"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                        http://symfony.com/schema/dic/monolog http://symfony.com/schema/dic/monolog/monolog-1.0.xsd"&gt;

    &lt;services&gt;
        &lt;service id="my_processor" class="Monolog\Processor\WebProcessor" /&gt;
    &lt;/services&gt;
    &lt;monolog:config&gt;
        &lt;monolog:handler
            name="file"
            type="stream"
            level="debug"
            formatter="my_formatter"
        &gt;
            &lt;monolog:processor callback="Acme\MyBundle\MyProcessor::process" /&gt;
        &lt;/monolog:handler /&gt;
        &lt;monolog:processor callback="@my_processor" /&gt;
    &lt;/monolog:config&gt;
		  &lt;/container&gt;</pre>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">If you need some dependencies in your processor you can define a
	      service and implement the <tt class="docutils literal"><span class="pre">__invoke</span></tt> method on the class to make
	      it callable. You can then add it in the processor stack.</p>
	</div></div>
	<div class="section" id="adding-a-session-request-token">
	  <h3>Adding a Session/Request Token<a class="headerlink" href="#adding-a-session-request-token" title="Permalink to this headline">¶</a></h3>
	  <p>Sometimes it is hard to tell which entries in the log belong to which session
	    and/or request. The following example will add a unique token for each request.</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\MyBundle</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Session</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">SessionRequestProcessor</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$session</span><span class="p">;</span>
    <span class="k">private</span> <span class="nv">$token</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">Session</span> <span class="nv">$session</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">session</span> <span class="o">=</span> <span class="nv">$session</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__invoke</span><span class="p">(</span><span class="k">array</span> <span class="nv">$record</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">if</span> <span class="p">(</span><span class="k">null</span> <span class="o">===</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span><span class="p">)</span> <span class="p">{</span>
            <span class="k">try</span> <span class="p">{</span>
                <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span> <span class="o">=</span> <span class="nb">substr</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">session</span><span class="o">-&gt;</span><span class="na">getId</span><span class="p">(),</span> <span class="mi">0</span><span class="p">,</span> <span class="mi">8</span><span class="p">);</span>
            <span class="p">}</span> <span class="k">catch</span> <span class="p">(</span><span class="nx">\RuntimeException</span> <span class="nv">$e</span><span class="p">)</span> <span class="p">{</span>
                <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span> <span class="o">=</span> <span class="s1">'????????'</span><span class="p">;</span>
            <span class="p">}</span>
            <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span> <span class="o">.=</span> <span class="s1">'-'</span> <span class="o">.</span> <span class="nb">substr</span><span class="p">(</span><span class="nb">uniqid</span><span class="p">(),</span> <span class="o">-</span><span class="mi">8</span><span class="p">);</span>
        <span class="p">}</span>
        <span class="nv">$record</span><span class="p">[</span><span class="s1">'extra'</span><span class="p">][</span><span class="s1">'token'</span><span class="p">]</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span><span class="p">;</span>

        <span class="k">return</span> <span class="nv">$record</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 397px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>services:
    monolog.formatter.session_request:
        class: Monolog\Formatter\LineFormatter
        arguments:
            - "[%%datetime%%] [%%extra.token%%] %%channel%%.%%level_name%%: %%message%%\n"

    monolog.processor.session_request:
        class: Acme\MyBundle\SessionRequestProcessor
        arguments:  [ @session ]

monolog:
    handlers:
        main:
            type: stream
            path: %kernel.logs_dir%/%kernel.environment%.log
            level: debug
            formatter: monolog.formatter.session_request
		    processors: [ @monolog.processor.session_request ]</pre>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If you use several handlers, you can also register the processor at the
		handler level instead of globally.</p>
	  </div></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to optimize your development Environment for debugging" href="../debugging.html">
      «&nbsp;How to optimize your development Environment for debugging
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to extend a Class without using Inheritance" href="../event_dispatcher/class_extension.html">
      How to extend a Class without using Inheritance&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
