<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Collection</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="collection">
      <h1>Collection<a class="headerlink" href="#collection" title="Permalink to this headline">¶</a></h1>
      <p>Validates array entries against different constraints.</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Collection</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">fields</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">key1</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotNull</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
        <span class="l-Scalar-Plain">key2</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">10</span>
	</pre></div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">fields</span></tt> (required): An associative array of array keys and one or more
	    constraints</li>
	  <li><tt class="docutils literal"><span class="pre">allowMissingFields</span></tt>: Whether some of the keys may not be present in the
	    array. Default: <tt class="docutils literal"><span class="pre">false</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">allowExtraFields</span></tt>: Whether the array may contain keys not present in the
	    <tt class="docutils literal"><span class="pre">fields</span></tt> option. Default: <tt class="docutils literal"><span class="pre">false</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">missingFieldsMessage</span></tt>: The error message if the <tt class="docutils literal"><span class="pre">allowMissingFields</span></tt>
	    validation fails</li>
	  <li><tt class="docutils literal"><span class="pre">allowExtraFields</span></tt>: The error message if the <tt class="docutils literal"><span class="pre">allowExtraFields</span></tt> validation
	    fails</li>
	</ul>
      </div>
      <div class="section" id="example">
	<h2>Example:<a class="headerlink" href="#example" title="Permalink to this headline">¶</a></h2>
	<p>Let's validate an array with two indexes <tt class="docutils literal"><span class="pre">firstName</span></tt> and <tt class="docutils literal"><span class="pre">lastName</span></tt>. The
	  value of <tt class="docutils literal"><span class="pre">firstName</span></tt> must not be blank, while the value of <tt class="docutils literal"><span class="pre">lastName</span></tt> must
	  not be blank with a minimum length of four characters. Furthermore, both keys
	  may not exist in the array.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 274px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">options</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Collection</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">fields</span><span class="p-Indicator">:</span>
                    <span class="l-Scalar-Plain">firstName</span><span class="p-Indicator">:</span>
                        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
                    <span class="l-Scalar-Plain">lastName</span><span class="p-Indicator">:</span>
                        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
                        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">4</span>
                <span class="l-Scalar-Plain">allowMissingFields</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"options"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Collection"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"fields"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;value</span> <span class="na">key=</span><span class="s">"firstName"</span><span class="nt">&gt;</span>
                    <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotNull"</span> <span class="nt">/&gt;</span>
                <span class="nt">&lt;/value&gt;</span>
                <span class="nt">&lt;value</span> <span class="na">key=</span><span class="s">"lastName"</span><span class="nt">&gt;</span>
                    <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotNull"</span> <span class="nt">/&gt;</span>
                    <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MinLength"</span><span class="nt">&gt;</span>4<span class="nt">&lt;/constraint&gt;</span>
                <span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;/option&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"allowMissingFields"</span><span class="nt">&gt;</span>true<span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\Collection(</span>
<span class="sd">     *   fields = {</span>
<span class="sd">     *     "firstName" = @Assert\NotNull(),</span>
<span class="sd">     *     "lastName" = { @Assert\NotBlank(), @Assert\MinLength(4) }</span>
<span class="sd">     *   },</span>
<span class="sd">     *   allowMissingFields = true</span>
<span class="sd">     * )</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$options</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\Collection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotNull</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\MinLength</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$options</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'options'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Collection</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'fields'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'firstName'</span> <span class="o">=&gt;</span> <span class="k">new</span> <span class="nx">NotNull</span><span class="p">(),</span>
                <span class="s1">'lastName'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">NotBlank</span><span class="p">(),</span> <span class="k">new</span> <span class="nx">MinLength</span><span class="p">(</span><span class="mi">4</span><span class="p">)),</span>
            <span class="p">),</span>
            <span class="s1">'allowMissingFields'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
        <span class="p">)));</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The following object would fail the validation.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$author</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Author</span><span class="p">();</span>
<span class="nv">$author</span><span class="o">-&gt;</span><span class="na">options</span><span class="p">[</span><span class="s1">'firstName'</span><span class="p">]</span> <span class="o">=</span> <span class="k">null</span><span class="p">;</span>
<span class="nv">$author</span><span class="o">-&gt;</span><span class="na">options</span><span class="p">[</span><span class="s1">'lastName'</span><span class="p">]</span> <span class="o">=</span> <span class="s1">'foo'</span><span class="p">;</span>

<span class="k">print</span> <span class="nv">$validator</span><span class="o">-&gt;</span><span class="na">validate</span><span class="p">(</span><span class="nv">$author</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>You should see the following error messages:</p>
	<div class="highlight-text"><div class="highlight"><pre>Acme\HelloBundle\Author.options[firstName]:
    This value should not be null
Acme\HelloBundle\Author.options[lastName]:
    This value is too short. It should have 4 characters or more
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Choice" href="Choice.html">
      «&nbsp;Choice
    </a><span class="separator">|</span>
    <a accesskey="N" title="Date" href="Date.html">
      Date&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
