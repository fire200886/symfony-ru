<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to work with Multiple Entity Managers</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-work-with-multiple-entity-managers">
      <h1>How to work with Multiple Entity Managers<a class="headerlink" href="#how-to-work-with-multiple-entity-managers" title="Permalink to this headline">¶</a></h1>
      <p>You can use multiple entity managers in a Symfony2 application. This is
	necessary if you are using different databases or even vendors with entirely
	different sets of entities. In other words, one entity manager that connects
	to one database will handle some entities while another entity manager that
	connects to another database might handle the rest.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">Using multiple entity managers is pretty easy, but more advanced and not
	    usually required. Be sure you actually need multiple entity managers before
	    adding in this layer of complexity.</p>
      </div></div>
      <p>The following configuration code shows how you can configure two entity managers:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 292px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">orm</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default_entity_manager</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">default</span>
        <span class="l-Scalar-Plain">entity_managers</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">default</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">connection</span><span class="p-Indicator">:</span>       <span class="l-Scalar-Plain">default</span>
                <span class="l-Scalar-Plain">mappings</span><span class="p-Indicator">:</span>
                    <span class="l-Scalar-Plain">AcmeDemoBundle</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
                    <span class="l-Scalar-Plain">AcmeStoreBundle</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="l-Scalar-Plain">customer</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">connection</span><span class="p-Indicator">:</span>       <span class="l-Scalar-Plain">customer</span>
                <span class="l-Scalar-Plain">mappings</span><span class="p-Indicator">:</span>
                    <span class="l-Scalar-Plain">AcmeCustomerBundle</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>In this case, you've defined two entity managers and called them <tt class="docutils literal"><span class="pre">default</span></tt>
	and <tt class="docutils literal"><span class="pre">customer</span></tt>. The <tt class="docutils literal"><span class="pre">default</span></tt> entity managers managers any entities in
	the <tt class="docutils literal"><span class="pre">AcmeDemoBundle</span></tt> and <tt class="docutils literal"><span class="pre">AcmeStoreBundle</span></tt>, while the <tt class="docutils literal"><span class="pre">customer</span></tt> entity
	manager manages any bundle in the <tt class="docutils literal"><span class="pre">AcmeCustomerBundle</span></tt>.</p>
      <p>When working with your entity managers, you should now be explicit about which
	entity manager you want. If you <em>do</em> omit the entity manager's name when
	asking for it, the default entity manager (i.e. <tt class="docutils literal"><span class="pre">default</span></tt>) is returned:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">UserController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// both return the "default" em</span>
        <span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
        <span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">(</span><span class="s1">'default'</span><span class="p">);</span>

        <span class="nv">$customerEm</span> <span class="o">=</span>  <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">(</span><span class="s1">'customer'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>You can now use Doctrine just as you did before - using the <tt class="docutils literal"><span class="pre">default</span></tt> entity
	manager to persist and fetch entities that it manages and the <tt class="docutils literal"><span class="pre">customer</span></tt>
	entity manager to persist and fetch its entities.</p>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use Doctrine's DBAL Layer" href="dbal.html">
      «&nbsp;How to use Doctrine's DBAL Layer
    </a><span class="separator">|</span>
    <a accesskey="N" title="Registering Custom DQL Functions" href="custom_dql_functions.html">
      Registering Custom DQL Functions&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
