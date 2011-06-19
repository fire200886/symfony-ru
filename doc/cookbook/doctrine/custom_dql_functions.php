<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Registering Custom DQL Functions</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="registering-custom-dql-functions">
      <h1>Registering Custom DQL Functions<a class="headerlink" href="#registering-custom-dql-functions" title="Permalink to this headline">¶</a></h1>
      <p>Doctrine allows you to specify custom DQL functions. For more information
	on this topic, read Doctrine's cookbook article "<a class="reference external" href="http://www.doctrine-project.org/docs/orm/2.0/en/cookbook/dql-user-defined-functions.html">DQL User Defined Functions</a>".</p>
      <p>In Symfony, you can register your custom DQL functions as follows:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 328px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">orm</span><span class="p-Indicator">:</span>
        <span class="c1"># ...</span>
        <span class="l-Scalar-Plain">entity_managers</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
                <span class="c1"># ...</span>
                <span class="l-Scalar-Plain">dql</span><span class="p-Indicator">:</span>
                    <span class="l-Scalar-Plain">string_functions</span><span class="p-Indicator">:</span>
                        <span class="l-Scalar-Plain">test_string</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\DQL\StringFunction</span>
                        <span class="l-Scalar-Plain">second_string</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\DQL\SecondStringFunction</span>
                    <span class="l-Scalar-Plain">numeric_functions</span><span class="p-Indicator">:</span>
                        <span class="l-Scalar-Plain">test_numeric</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\DQL\NumericFunction</span>
                    <span class="l-Scalar-Plain">datetime_functions</span><span class="p-Indicator">:</span>
                        <span class="l-Scalar-Plain">test_datetime</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\DQL\DatetimeFunction</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- app/config/config.xml --&gt;
&lt;container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:doctrine="http://symfony.com/schema/dic/doctrine"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                        http://symfony.com/schema/dic/doctrine http://symfony.com/schema/dic/doctrine/doctrine-1.0.xsd"&gt;

    &lt;doctrine:config&gt;
        &lt;doctrine:orm&gt;
            &lt;!-- ... --&gt;
            &lt;doctrine:entity-manager name="default"&gt;
                &lt;!-- ... --&gt;
                &lt;doctrine:dql&gt;
                    &lt;doctrine:string-function name="test_string&gt;Acme\HelloBundle\DQL\StringFunction&lt;/doctrine:string-function&gt;
                    &lt;doctrine:string-function name="second_string&gt;Acme\HelloBundle\DQL\SecondStringFunction&lt;/doctrine:string-function&gt;
                    &lt;doctrine:numeric-function name="test_numeric&gt;Acme\HelloBundle\DQL\NumericFunction&lt;/doctrine:numeric-function&gt;
                    &lt;doctrine:datetime-function name="test_datetime&gt;Acme\HelloBundle\DQL\DatetimeFunction&lt;/doctrine:datetime-function&gt;
                &lt;/doctrine:dql&gt;
            &lt;/doctrine:entity-manager&gt;
        &lt;/doctrine:orm&gt;
    &lt;/doctrine:config&gt;
		&lt;/container&gt;</pre>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'orm'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">// ...</span>
        <span class="s1">'entity_managers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'default'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="c1">// ...</span>
                <span class="s1">'dql'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                    <span class="s1">'string_functions'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                        <span class="s1">'test_string'</span>   <span class="o">=&gt;</span> <span class="s1">'Acme\HelloBundle\DQL\StringFunction'</span><span class="p">,</span>
                        <span class="s1">'second_string'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\HelloBundle\DQL\SecondStringFunction'</span><span class="p">,</span>
                    <span class="p">),</span>
                    <span class="s1">'numeric_functions'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                        <span class="s1">'test_numeric'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\HelloBundle\DQL\NumericFunction'</span><span class="p">,</span>
                    <span class="p">),</span>
                    <span class="s1">'datetime_functions'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                        <span class="s1">'test_datetime'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\HelloBundle\DQL\DatetimeFunction'</span><span class="p">,</span>
                    <span class="p">),</span>
                <span class="p">),</span>
            <span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to work with Multiple Entity Managers" href="multiple_entity_managers.html">
      «&nbsp;How to work with Multiple Entity Managers
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to customize Form Rendering in a Twig Template" href="../form/twig_form_customization.html">
      How to customize Form Rendering in a Twig Template&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
