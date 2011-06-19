<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">


  <div class="box_title">
    <h1 class="title_01">Registering Event Listeners and Subscribers</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="registering-event-listeners-and-subscribers">
      <span id="doctrine-event-config"></span><h1>Registering Event Listeners and Subscribers<a class="headerlink" href="#registering-event-listeners-and-subscribers" title="Permalink to this headline">¶</a></h1>
      <p>Doctrine uses the lightweight <tt class="docutils literal"><span class="pre">Doctrine\Common\EventManager</span></tt> class to
	trigger a number of different events which you can hook into. You can register
	Event Listeners or Subscribers by tagging the respective services with
	<tt class="docutils literal"><span class="pre">doctrine.event_listener</span></tt> or <tt class="docutils literal"><span class="pre">doctrine.event_subscriber</span></tt> using the service
	container.</p>
      <p>To register services to act as event listeners or subscribers (listeners from
	here) you have to tag them with the appropriate names. Depending on your
	use-case you can hook a listener into every DBAL Connection and ORM Entity
	Manager or just into one specific DBAL connection and all the EntityManagers
	that use this connection.</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 436px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">dbal</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default_connection</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">default</span>
        <span class="l-Scalar-Plain">connections</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">driver</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">pdo_sqlite</span>
                <span class="l-Scalar-Plain">memory</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>

<span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">my.listener</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">MyEventListener</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">doctrine.event_listener</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">my.listener2</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">MyEventListener2</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">doctrine.event_listener</span><span class="p-Indicator">,</span> <span class="nv">connection</span><span class="p-Indicator">:</span> <span class="nv">default</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">my.subscriber</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">MyEventSubscriber</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">doctrine.event_subscriber</span><span class="p-Indicator">,</span> <span class="nv">connection</span><span class="p-Indicator">:</span> <span class="nv">default</span> <span class="p-Indicator">}</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" ?&gt;</span>
<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:doctrine=</span><span class="s">"http://symfony.com/schema/dic/doctrine"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;doctrine:config&gt;</span>
        <span class="nt">&lt;doctrine:dbal</span> <span class="na">default-connection=</span><span class="s">"default"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;doctrine:connection</span> <span class="na">driver=</span><span class="s">"pdo_sqlite"</span> <span class="na">memory=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/doctrine:dbal&gt;</span>
    <span class="nt">&lt;/doctrine:config&gt;</span>

    <span class="nt">&lt;services&gt;</span>
        <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my.listener"</span> <span class="na">class=</span><span class="s">"MyEventListener"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"doctrine.event_listener"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/service&gt;</span>
        <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my.listener2"</span> <span class="na">class=</span><span class="s">"MyEventListener2"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"doctrine.event_listener"</span> <span class="na">connection=</span><span class="s">"default"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/service&gt;</span>
        <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my.subscriber"</span> <span class="na">class=</span><span class="s">"MyEventSubscriber"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"doctrine.event_subscriber"</span> <span class="na">connection=</span><span class="s">"default"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/service&gt;</span>
    <span class="nt">&lt;/services&gt;</span>
<span class="nt">&lt;/container&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Doctrine Extensions: Timestampable: Sluggable, Translatable, etc." href="common_extensions.html">
      «&nbsp;Doctrine Extensions: Timestampable: Sluggable, Translatable, etc.
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to generate Entities from an Existing Database" href="reverse_engineering.html">
      How to generate Entities from an Existing Database&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
