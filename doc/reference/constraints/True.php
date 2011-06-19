<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">True</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="true">
      <h1>True<a class="headerlink" href="#true" title="Permalink to this headline">¶</a></h1>
      <p>Validates that a value is <tt class="docutils literal"><span class="pre">true</span></tt>.</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">termsAccepted</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">True</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
	</pre></div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">message</span></tt>: The error message if validation fails</li>
	</ul>
      </div>
      <div class="section" id="example">
	<h2>Example<a class="headerlink" href="#example" title="Permalink to this headline">¶</a></h2>
	<p>This constraint is very useful to execute custom validation logic. You can
	  put the logic in a method which returns either <tt class="docutils literal"><span class="pre">true</span></tt> or <tt class="docutils literal"><span class="pre">false</span></tt>.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// Acme/HelloBundle/Author.php</span>
<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$token</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span> <span class="o">==</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateToken</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Then you can constrain this method with <tt class="xref docutils literal"><span class="pre">True</span></tt>.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">getters</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">tokenValid</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">True</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">message</span><span class="p-Indicator">:</span> <span class="s">"The</span><span class="nv"> </span><span class="s">token</span><span class="nv"> </span><span class="s">is</span><span class="nv"> </span><span class="s">invalid"</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;getter</span> <span class="na">name=</span><span class="s">"tokenValid"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"True"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"message"</span><span class="nt">&gt;</span>The token is invalid<span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/getter&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$token</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\True(message = "The token is invalid")</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span> <span class="o">==</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateToken</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\True</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$token</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addGetterConstraint</span><span class="p">(</span><span class="s1">'tokenValid'</span><span class="p">,</span> <span class="k">new</span> <span class="k">True</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'message'</span> <span class="o">=&gt;</span> <span class="s1">'The token is invalid'</span><span class="p">,</span>
        <span class="p">)));</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">token</span> <span class="o">==</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateToken</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>If the validation of this method fails, you will see a message similar to
	  this:</p>
	<div class="highlight-text"><div class="highlight"><pre>Acme\HelloBundle\Author.tokenValid:
    This value should not be null
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="False" href="False.html">
      «&nbsp;False
    </a><span class="separator">|</span>
    <a accesskey="N" title="Type" href="Type.html">
      Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
