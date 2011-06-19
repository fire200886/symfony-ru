<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Choice</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="choice">
      <h1>Choice<a class="headerlink" href="#choice" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">Choice</span></tt> constraint validates that a given value is one or more of
	a list of given choices.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="18%">
	  <col width="82%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Validates</td>
	    <td>a scalar value or an array of scalar values (if <tt class="docutils literal"><span class="pre">multiple</span></tt> is true)</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">choices</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">callback</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">multiple</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">min</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">max</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">message</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">minMessage</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">maxMessage</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Default Option</td>
	    <td><tt class="docutils literal"><span class="pre">choices</span></tt></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/Constraints/Choice.html" title="Symfony\Component\Validator\Constraints\Choice"><span class="pre">Choice</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="available-options">
	<h2>Available Options<a class="headerlink" href="#available-options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">choices</span></tt> (<strong>default</strong>) [type: array]</dt>
	      <dd><p class="first last">A required option (unless <tt class="docutils literal"><span class="pre">callback</span></tt> is specified) - this is the array
		  of options that should be considered in the valid set. The input value
		  will be matched against this array.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">callback</span></tt>: [type: string|array]</dt>
	      <dd><p class="first">This is a static callback method that can be used instead of the <tt class="docutils literal"><span class="pre">choices</span></tt>
		  option to return the choices array.</p>
		<p>If you pass a string method name (e.g. <tt class="docutils literal"><span class="pre">getGenders</span></tt>), that static method
		  will be called on the validated class.</p>
		<p class="last">If you pass an array (e.g. <tt class="docutils literal"><span class="pre">array('Util',</span> <span class="pre">'getGenders')</span></tt>), it follows
		  the normal callable syntax where the first argument is the class name
		  and the second argument is the method name.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">multiple</span></tt>: [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If this option is true, the input value is expected to be an array instead
		  of a single, scalar value. The constraint will check that each value of
		  the input array can be found in the array of valid choices. If even one
		  of the input values cannot be found, the validation will fail.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">min</span></tt>: [type: integer]</dt>
	      <dd><p class="first last">If the <tt class="docutils literal"><span class="pre">multiple</span></tt> option is true, then you can use the <tt class="docutils literal"><span class="pre">min</span></tt> option
		  to force at least XX number of values to be selected. For example, if
		  <tt class="docutils literal"><span class="pre">min</span></tt> is 3, but the input array only contains 2 valid items, the
		  validation will fail.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">max</span></tt>: [type: integer]</dt>
	      <dd><p class="first last">If the <tt class="docutils literal"><span class="pre">multiple</span></tt> option is true, then you can use the <tt class="docutils literal"><span class="pre">max</span></tt> option
		  to force no more than XX number of values to be selected. For example, if
		  <tt class="docutils literal"><span class="pre">max</span></tt> is 3, but the input array contains 4 valid items, the validation
		  will fail.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">message</span></tt>: [type: string, default: <cite>This value should be one of the given choices</cite>]</dt>
	      <dd><p class="first last">This is the validation error message that's displayed when the input
		  value is invalid.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">minMessage</span></tt>: [type: string, default: <cite>You should select at least {{ limit }} choices</cite>]</dt>
	      <dd><p class="first last">This is the validation error message that's displayed when the user chooses
		  too few options per the <tt class="docutils literal"><span class="pre">min</span></tt> option.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">maxMessage</span></tt>: [type: string, default: <cite>You should select at most {{ limit }} choices</cite>]</dt>
	      <dd><p class="first last">This is the validation error message that's displayed when the user chooses
		  too many options per the <tt class="docutils literal"><span class="pre">max</span></tt> option.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
      <div class="section" id="basic-usage">
	<h2>Basic Usage<a class="headerlink" href="#basic-usage" title="Permalink to this headline">¶</a></h2>
	<p>If the choices are simple, they can be passed to the constraint definition
	  as an array.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 184px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">choices</span><span class="p-Indicator">:</span>  <span class="p-Indicator">[</span><span class="nv">male</span><span class="p-Indicator">,</span> <span class="nv">female</span><span class="p-Indicator">]</span>
                <span class="l-Scalar-Plain">message</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">Choose a valid gender.</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"choices"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;value&gt;</span>male<span class="nt">&lt;/value&gt;</span>
                <span class="nt">&lt;value&gt;</span>female<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;/option&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"message"</span><span class="nt">&gt;</span>Choose a valid gender.<span class="nt">&lt;/option&gt;</span>
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
<span class="sd">     * @Assert\Choice(choices = {"male", "female"}, message = "Choose a valid gender.")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\Choice</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Choice</span><span class="p">(</span>
            <span class="s1">'choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'male'</span><span class="p">,</span> <span class="s1">'female'</span><span class="p">),</span>
            <span class="s1">'message'</span> <span class="o">=&gt;</span> <span class="s1">'Choose a valid gender'</span><span class="p">,</span>
        <span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="supplying-the-choices-with-a-callback-function">
	<h2>Supplying the Choices with a Callback Function<a class="headerlink" href="#supplying-the-choices-with-a-callback-function" title="Permalink to this headline">¶</a></h2>
	<p>You can also use a callback function to specify your options. This is useful
	  if you want to keep your choices in some central location so that, for example,
	  you can easily access those choices for validation or for building a select
	  form element.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">getGenders</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'male'</span><span class="p">,</span> <span class="s1">'female'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>You can pass the name of this method to the <tt class="docutils literal"><span class="pre">callback</span></tt> option of the <tt class="docutils literal"><span class="pre">Choice</span></tt>
	  constraint.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">callback</span><span class="p-Indicator">:</span> <span class="nv">getGenders</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"callback"</span><span class="nt">&gt;</span>getGenders<span class="nt">&lt;/option&gt;</span>
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
<span class="sd">     * @Assert\Choice(callback = "getGenders")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>If the static callback is stored in a different class, for example <tt class="docutils literal"><span class="pre">Util</span></tt>,
	  you can pass the class name and the method as an array.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">callback</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">Util</span><span class="p-Indicator">,</span> <span class="nv">getGenders</span><span class="p-Indicator">]</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"callback"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;value&gt;</span>Util<span class="nt">&lt;/value&gt;</span>
                <span class="nt">&lt;value&gt;</span>getGenders<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;/option&gt;</span>
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
<span class="sd">     * @Assert\Choice(callback = {"Util", "getGenders"})</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Callback" href="Callback.html">
      «&nbsp;Callback
    </a><span class="separator">|</span>
    <a accesskey="N" title="Collection" href="Collection.html">
      Collection&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
