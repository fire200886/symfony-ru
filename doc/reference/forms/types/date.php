<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">date Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="date-field-type">
      <span id="index-0"></span><h1>date Field Type<a class="headerlink" href="#date-field-type" title="Permalink to this headline">¶</a></h1>
      <p>A field that allows the user to modify date information via a variety of
	different HTML elements.</p>
      <p>The underlying data used for this field type can be a <tt class="docutils literal"><span class="pre">DateTime</span></tt> object,
	a string, a timestamp or an array. As long as the <tt class="docutils literal"><span class="pre">input</span></tt> option is set
	correctly, the field will take care of all of the details (see the <tt class="docutils literal"><span class="pre">input</span></tt> option).</p>
      <p>The field can be rendered as a single text box or three select boxes (month,
	day, and year).</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="22%">
	  <col width="78%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Underlying Data Type</td>
	    <td>can be <tt class="docutils literal"><span class="pre">DateTime</span></tt>, string, timestamp, or array (see the <tt class="docutils literal"><span class="pre">input</span></tt> option)</td>
	  </tr>
	  <tr><td>Rendered as</td>
	    <td>single text box or three select fields</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">widget</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">input</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">years</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">months</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">days</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">format</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">pattern</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">data_timezone</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">user_timezone</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><tt class="docutils literal"><span class="pre">field</span></tt> (if text), <tt class="docutils literal"><span class="pre">form</span></tt> otherwise</td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/DateType.html" title="Symfony\Component\Form\Extension\Core\Type\DateType"><span class="pre">DateType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="basic-usage">
	<h2>Basic Usage<a class="headerlink" href="#basic-usage" title="Permalink to this headline">¶</a></h2>
	<p>This field type is highly configurable, but easy to use. The most important
	  options are <tt class="docutils literal"><span class="pre">input</span></tt> and <tt class="docutils literal"><span class="pre">widget</span></tt>.</p>
	<p>Suppose that you have a <tt class="docutils literal"><span class="pre">publishedAt</span></tt> field whose underlying date is a
	  <tt class="docutils literal"><span class="pre">DateTime</span></tt> object. The following configures the <tt class="docutils literal"><span class="pre">date</span></tt> type for that
	  field as three different choice fields:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'publishedAt'</span><span class="p">,</span> <span class="s1">'date'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'input'</span>  <span class="o">=&gt;</span> <span class="s1">'datetime'</span><span class="p">,</span>
    <span class="s1">'widget'</span> <span class="o">=&gt;</span> <span class="s1">'choice'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">input</span></tt> option <em>must</em> be changed to match the type of the underlying
	  date data. For example, if the <tt class="docutils literal"><span class="pre">publishedAt</span></tt> field's data were a unix timestamp,
	  you'd need to set <tt class="docutils literal"><span class="pre">input</span></tt> to <tt class="docutils literal"><span class="pre">timestamp</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'publishedAt'</span><span class="p">,</span> <span class="s1">'date'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'input'</span>  <span class="o">=&gt;</span> <span class="s1">'timestamp'</span><span class="p">,</span>
    <span class="s1">'widget'</span> <span class="o">=&gt;</span> <span class="s1">'choice'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>The field also supports an <tt class="docutils literal"><span class="pre">array</span></tt> and <tt class="docutils literal"><span class="pre">string</span></tt> as valid <tt class="docutils literal"><span class="pre">input</span></tt> option
	  values.</p>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">widget</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">choice</span></tt>]</dt>
	      <dd><p class="first">Type of widget used for this form type.  Can be <tt class="docutils literal"><span class="pre">text</span></tt> or <tt class="docutils literal"><span class="pre">single_text</span></tt> or <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
		<blockquote class="last">
		  <div><ul class="simple">
		      <li><tt class="docutils literal"><span class="pre">text</span></tt>: renders a three field input of type text (month, day, year).</li>
		      <li><tt class="docutils literal"><span class="pre">single_text</span></tt>: renders a single input of type text. User's input is validated
			based on the <tt class="docutils literal"><span class="pre">format</span></tt> option.</li>
		      <li><tt class="docutils literal"><span class="pre">choice</span></tt>: renders three select inputs.  The order of the selects
			is defined in the <tt class="docutils literal"><span class="pre">pattern</span></tt> option.</li>
		    </ul>
		</div></blockquote>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul id="form-reference-date-input">
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">input</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">datetime</span></tt>]</dt>
	      <dd><p class="first">The value of the input for the widget.  Can be <tt class="docutils literal"><span class="pre">string</span></tt>, <tt class="docutils literal"><span class="pre">datetime</span></tt>
		  or <tt class="docutils literal"><span class="pre">array</span></tt>.  The form type input value will be returned  in the format
		  specified.  The input of <tt class="docutils literal"><span class="pre">April</span> <span class="pre">21th,</span> <span class="pre">2011</span></tt> as an array would return:</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span><span class="s1">'month'</span> <span class="o">=&gt;</span> <span class="mi">4</span><span class="p">,</span> <span class="s1">'day'</span> <span class="o">=&gt;</span> <span class="mi">21</span><span class="p">,</span> <span class="s1">'year'</span> <span class="o">=&gt;</span> <span class="mi">2011</span> <span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">years</span></tt> [type: array, default: five years before to five years after the current year ]</dt>
	      <dd><p class="first last">List of years available to the year field type.  This option is only
		  relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">months</span></tt> [type: array, default: 1 to 12 ]</dt>
	      <dd><p class="first last">List of months available to the month field type. This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">days</span></tt> [type: array, default: 1 to 31 ]</dt>
	      <dd><p class="first">List of days available to the day field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="s1">'days'</span> <span class="o">=&gt;</span> <span class="nb">range</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span><span class="mi">31</span><span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">format</span></tt> [type: integer, default: IntlDateFormatter::MEDIUM]</dt>
	      <dd><p class="first last">Option passed to the IntlDateFormatter class, used to transform user input
		  into the proper format. This is critical when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is
		  set to <tt class="docutils literal"><span class="pre">text</span></tt>, and will define how to transform the input.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">pattern</span></tt> [type: string, default: null]</dt>
	      <dd><p class="first">This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.
		  The default pattern is based off the <tt class="docutils literal"><span class="pre">format</span></tt> option, and tries to
		  match the characters <tt class="docutils literal"><span class="pre">M</span></tt>, <tt class="docutils literal"><span class="pre">d</span></tt>, and <tt class="docutils literal"><span class="pre">y</span></tt> in the format pattern. If
		  no match is found, the default is the string <tt class="docutils literal"><span class="pre">{{</span> <span class="pre">year</span> <span class="pre">}}-{{</span> <span class="pre">month</span> <span class="pre">}}-{{</span> <span class="pre">day</span> <span class="pre">}}</span></tt>.
		  Tokens for this option include:</p>
		<blockquote class="last">
		  <div><ul class="simple">
		      <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">year</span> <span class="pre">}}</span></tt>: Replaced with the <tt class="docutils literal"><span class="pre">year</span></tt> widget</li>
		      <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">month</span> <span class="pre">}}</span></tt>: Replaced with the <tt class="docutils literal"><span class="pre">month</span></tt> widget</li>
		      <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">day</span> <span class="pre">}}</span></tt>: Replaced with the <tt class="docutils literal"><span class="pre">day</span></tt> widget</li>
		    </ul>
		</div></blockquote>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">data_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being stored.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">user_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being submitted by the user.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="csrf Field Type" href="csrf.html">
      «&nbsp;csrf Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="datetime Field Type" href="datetime.html">
      datetime Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>

