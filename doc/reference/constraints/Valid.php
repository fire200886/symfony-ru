<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Valid</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="valid">
      <h1>Valid<a class="headerlink" href="#valid" title="Permalink to this headline">¶</a></h1>
      <p>Marks an associated object to be validated itself.</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">address</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Valid</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
	</pre></div>
      </div>
      <div class="section" id="example-validate-object-graphs">
	<h2>Example: Validate object graphs<a class="headerlink" href="#example-validate-object-graphs" title="Permalink to this headline">¶</a></h2>
	<p>This constraint helps to validate whole object graphs. In the following example,
	  we create two classes <tt class="docutils literal"><span class="pre">Author</span></tt> and <tt class="docutils literal"><span class="pre">Address</span></tt> that both have constraints on
	  their properties. Furthermore, <tt class="docutils literal"><span class="pre">Author</span></tt> stores an <tt class="docutils literal"><span class="pre">Address</span></tt> instance in the
	  <tt class="docutils literal"><span class="pre">$address</span></tt> property.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Address.php</span>
<span class="k">class</span> <span class="nc">Address</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$street</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$zipCode</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$firstName</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$lastName</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$address</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 346px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Address</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">street</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
        <span class="l-Scalar-Plain">zipCode</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MaxLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">5</span>

<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">firstName</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">4</span>
        <span class="l-Scalar-Plain">lastName</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Address"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"street"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"zipCode"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MaxLength"</span><span class="nt">&gt;</span>5<span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>

<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"firstName"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MinLength"</span><span class="nt">&gt;</span>4<span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"lastName"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Address.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Address</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$street</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank</span>
<span class="sd">     * @Assert\MaxLength(5)</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$zipCode</span><span class="p">;</span>
<span class="p">}</span>

<span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank</span>
<span class="sd">     * @Assert\MinLength(4)</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$firstName</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$lastName</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$address</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Address.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\MaxLength</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Address</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$street</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$zipCode</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'street'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'zipCode'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'zipCode'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">MaxLength</span><span class="p">(</span><span class="mi">5</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>

<span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\MinLength</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$firstName</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$lastName</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$address</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'firstName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'firstName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">MinLength</span><span class="p">(</span><span class="mi">4</span><span class="p">));</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'lastName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>With this mapping it is possible to successfully validate an author with an
	  invalid address. To prevent that, we add the <tt class="docutils literal"><span class="pre">Valid</span></tt> constraint to the
	  <tt class="docutils literal"><span class="pre">$address</span></tt> property.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">address</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Valid</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"address"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Valid"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="cm">/* ... */</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\Valid</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$address</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\Valid</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$address</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'address'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Valid</span><span class="p">());</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>If you validate an author with an invalid address now, you can see that the
	  validation of the <tt class="docutils literal"><span class="pre">Address</span></tt> fields failed.</p>
	<blockquote>
	  <div><dl class="docutils">
	      <dt>AcmeHelloBundleAuthor.address.zipCode:</dt>
	      <dd>This value is too long. It should have 5 characters or less</dd>
	    </dl>
	</div></blockquote>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Url" href="Url.html">
      «&nbsp;Url
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Dependency Injection Tags" href="../dic_tags.html">
      The Dependency Injection Tags&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
