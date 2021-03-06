<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/common_functions.php');
require_once 'include/MVC/View/views/view.list.php';
require_once 'custom/modules/Leads/CustomListViewSmarty.php';
require_once 'custom/modules/Leads/CustomListViewData.php';
require_once('custom/include/SearchForm/PlOppSearchForm2.php');

class LeadsViewList extends ViewList {
	
    function LeadsViewList() {
        parent::ViewList();
    }
    /**
     * For custom list view data object
     * @modified Mohit Kumar Gupta
     * @see ViewList::preDisplay()
     */
    function preDisplay(){ 	
    	$this->lv = new CustomListViewSmarty();
    	$this->lv->quickViewLinks  = false;
    	$this->lv->lvd = new CustomListViewData();
    	//to allow browser's back button for search
    	header('Expires: -1');                
        header( 'Cache-Control: must-revalidate, post-check=3600, pre-check=3600' );
    }
	//BBSMP-242 -- START
	function listViewPrepare() {    
		if($_REQUEST['orderBy']) { 
			$_REQUEST['orderBy'] = strtoupper('date_modified');  
			$_REQUEST['sortOrder'] = 'DESC'; 
			$_REQUEST['overrideOrder'] = true;
		} 
		parent::listViewPrepare(); 
	}
	//BBSMP-242 -- END
    function display() {
		
		echo "<style>
				.yui-ac-content{
					width: auto;
				}
			</style>";
    	
        require_once 'custom/modules/Leads/bbProjectLeads.php';
        $this->bean = new bbProjectLeads();        
        
        //fix -- county not popuate inn save search
        if(isset($_REQUEST['saved_search_select']) && !empty($_REQUEST['saved_search_select']) ){
        	$savedSearch = new SavedSearch();
        	$retrieveSavedSearch = $savedSearch->retrieveSavedSearch($_REQUEST['saved_search_select']);
        	$savedSearchOptions = $savedSearch->populateRequest();
        }else{
        	unset($_SESSION['LastSavedView'][$this->module]);
        }
        
        //if there are counties specified in advance search then show them as selected
        if(isset($_REQUEST['county_id_advanced'])){
        	$SELECTED_COUNTIES = json_encode($_REQUEST['county_id_advanced']);	
		}else{			
			$SELECTED_COUNTIES = json_encode(array(''));
		}

		$pull_from_menu = 0;
		if(isset($_REQUEST['pull_project'])){
			$pull_from_menu = 1;
		}
		
		$min_one_bidder = 0;
		if(isset($_REQUEST['min_one_bidder'])){
			$min_one_bidder=1;
		}
		
        parent::display();
        
        /*if(isset($_REQUEST['no_lead'])){
        	echo '<script type="text/javascript">
        		ajaxStatus.showStatus("No new or modified project leads are available.");        		
        		</script>';
        }*/
        
        echo <<<EOQ
<script type='text/javascript'>
        
        //overwrite default mass update function
		 sugarListView.prototype.send_mass_update = function(mode, no_record_txt, del) {
        	//remove default onsubmit check_form from massupdate form, we will apply check_form mannualy here.	
        	//@modified by Mohit Kumar Gupta
        	//@date 02-12-2013        	
        	document.getElementById("MassUpdate").onsubmit = null;
			formValid = check_form('MassUpdate');
			if(!formValid && !del) return false;
		
		
			if (document.MassUpdate.select_entire_list &&
				document.MassUpdate.select_entire_list.value == 1)
				mode = 'entire';
			else
				mode = 'selected';
		
			var ar = new Array();
		
			switch(mode) {
				case 'selected':
					for(var wp = 0; wp < document.MassUpdate.elements.length; wp++) {
						var reg_for_existing_uid = new RegExp('^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$|^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$');
						//when the uid is already in document.MassUpdate.uid.value, we should not add it to ar.
						if(typeof document.MassUpdate.elements[wp].name != 'undefined'
							&& document.MassUpdate.elements[wp].name == 'mass[]'
								&& document.MassUpdate.elements[wp].checked
								&& !reg_for_existing_uid.test(document.MassUpdate.uid.value)) {
									ar.push(document.MassUpdate.elements[wp].value);
						}
					}
					if(document.MassUpdate.uid.value != '') document.MassUpdate.uid.value += ',';
					document.MassUpdate.uid.value += ar.join(',');
					if(document.MassUpdate.uid.value == '') {
						alert(no_record_txt);
						return false;
					}
					if(typeof(current_admin_id)!='undefined' && document.MassUpdate.module!= 'undefined' && document.MassUpdate.module.value == 'Users' && (document.MassUpdate.is_admin.value!='' || document.MassUpdate.status.value!='')) {
						var reg_for_current_admin_id = new RegExp('^'+current_admin_id+'[\s]*,|,[\s]*'+current_admin_id+'[\s]*,|,[\s]*'+current_admin_id+'$|^'+current_admin_id+'$');
						if(reg_for_current_admin_id.test(document.MassUpdate.uid.value)) {
							//if current user is admin, we should not allow massupdate the user_type and status of himself
							alert(SUGAR.language.get('Users','LBL_LAST_ADMIN_NOTICE'));
							return false;
						}
					}
					break;
				case 'entire':
					var entireInput = document.createElement('input');
					entireInput.name = 'entire';
					entireInput.type = 'hidden';
					entireInput.value = 'index';
					document.MassUpdate.appendChild(entireInput);
					//confirm(no_record_txt);
					if(document.MassUpdate.module!= 'undefined' && document.MassUpdate.module.value == 'Users' && (document.MassUpdate.is_admin.value!='' || document.MassUpdate.status.value!='')) {
						alert(SUGAR.language.get('Users','LBL_LAST_ADMIN_NOTICE'));
						return false;
					}
					break;
			}
		
		
			if(del == 1) {
        		
        		var callback = {
					success:function(o){
        				
        				if(parseInt(o.responseText) > 0)
        					var confirm_message = 'You are attempting to delete a Project Lead that has been converted into an opportunity, if you continue to delete this Project Lead you will no longer be able to access information on that opportunity related to this Project Lead.';
        				else
        					var confirm_message =  SUGAR.language.get('app_strings', 'NTC_DELETE_CONFIRMATION_NUM') + sugarListView.get_num_selected()  + SUGAR.language.get('app_strings', 'NTC_DELETE_SELECTED_RECORDS');
        				
        				if(!confirm(confirm_message))
        					return false;
        				
        				var deleteInput = document.createElement('input');
						deleteInput.name = 'Delete';
						deleteInput.type = 'hidden';
						deleteInput.value = true;
						document.MassUpdate.appendChild(deleteInput);
						if(document.MassUpdate.module!= 'undefined' && document.MassUpdate.module.value == 'EmailTemplates') {
							check_used_email_templates();
							return false;
						}
        		
        				document.MassUpdate.submit();
						return false;
					}
				};
        		
				if(mode == 'selected')
        			var selected = '&selected='+document.MassUpdate.uid.value;
        		else
        			var selected = '&selected=all';
        		
				var connectionObject = YAHOO.util.Connect.asyncRequest ("POST", "index.php?module=Leads&action=getconvertedcount&to_pdf=true",callback,selected);
			}else {
                
                archive_flag = $('#is_archived').val(); 
                //add condition for archive leads
                //@modifie By Mohit Kumar Gupta 04-02-2014               
                if(archive_flag !='undefined' && archive_flag == '1'){
                    return confirm( SUGAR.language.get('app_strings', 'ARCHIVE_UPDATE_CONFIRMATION_NUM') + sugarListView.get_num_selected()  + SUGAR.language.get('app_strings', 'NTC_DELETE_SELECTED_RECORDS'));
                } else {
                    return confirm( SUGAR.language.get('app_strings', 'NTC_UPDATE_CONFIRMATION_NUM') + sugarListView.get_num_selected()  + SUGAR.language.get('app_strings', 'NTC_DELETE_SELECTED_RECORDS'));
                }				
			}
		
			
	    }
        		
       YAHOO.util.Event.onDOMReady(function(){
          if(document.getElementById('classification').value==''){
            document.getElementById('classification').value='Search by Classification..';
          }
          if(document.getElementById('classification_1').value==''){
            document.getElementById('classification_1').value='Search by Classification..';
          }
          if(document.getElementById('classification_2').value==''){
            document.getElementById('classification_2').value='Search by Classification..';
          }
       });
        
       YAHOO.util.Event.addListener('classification', 'click', function(){
            if(this.value=='Search by Classification..'){
                this.value='';
            }
        });
        YAHOO.util.Event.addListener('classification_1', 'click', function(){
            if(this.value=='Search by Classification..'){
                this.value='';
            }
        });
        YAHOO.util.Event.addListener('classification_2', 'click', function(){
            if(this.value=='Search by Classification..'){
                this.value='';
            }
        });
        
        YAHOO.util.Event.addListener('classification', 'blur', function(){
            if(this.value==''){
                this.value='Search by Classification..';
            }
        });
        YAHOO.util.Event.addListener('classification_1', 'blur', function(){
            if(this.value==''){
                this.value='Search by Classification..';
            }
        });
        YAHOO.util.Event.addListener('classification_2', 'blur', function(){
            if(this.value==''){
                this.value='Search by Classification..';
            }
        });
        
        YAHOO.util.Event.addListener('search_form_submit', 'click', function(){
           		//alert("hi");
            if(document.getElementById('classification').value=='Search by Classification..'){
        		document.getElementById('classification_basic').value='';
                document.getElementById('classification').value = '';
            }
            if(document.getElementById('classification_1').value=='Search by Classification..'){
        		document.getElementById('classification_basic').value='';
                document.getElementById('classification_1').value = '';
            }
            if(document.getElementById('classification_2').value=='Search by Classification..'){
        		document.getElementById('classification_basic').value='';
                document.getElementById('classification_2').value = '';
            }
        });
        
        YAHOO.util.Event.addListener('search_form_clear', 'click', function(){
            document.getElementById('classification').value = 'Search by Classification..';
            document.getElementById('classification_1').value='Search by Classification..';
            document.getElementById('classification_2').value='Search by Classification..';
        
        });
        
        YAHOO.util.Event.onDOMReady(function(){
        
        var container = document.createElement('div');
        container.innerHTML = '';
        container.id = 'classificationContainer';
        
        var container_1 = document.createElement('div');
        container_1.innerHTML = '';
        container_1.id = 'classification_1Container';
        
        var container_2 = document.createElement('div');
        container_2.innerHTML = '';
        container_2.id = 'classification_2Container';
        
        YAHOO.util.Dom.insertAfter(container ,YAHOO.util.Dom.get('classification'));
        YAHOO.util.Dom.insertAfter(container_1 ,YAHOO.util.Dom.get('classification_1'));
        YAHOO.util.Dom.insertAfter(container_2 ,YAHOO.util.Dom.get('classification_2'));
        
        YAHOO.example.classification = function() {
        
	var oConfigs = {
            prehighlightClassName: 'yui-ac-prehighlight',
            queryDelay: 0,
            minQueryLength: 0,
            animVert: .01,
            useIFrame: true
        }
        
        // instantiate remote data source
        var oDS = new YAHOO.util.XHRDataSource('index.php?');
        oDS.responseType = YAHOO.util.XHRDataSource.TYPE_HTMLTABLE;
        oDS.responseSchema = {
           fields: ['name']
        };
        
        oDS.maxCacheEntries = 10;
        
        var oAC = new YAHOO.widget.AutoComplete('classification', 'classificationContainer', oDS, oConfigs);
        var oAC1 = new YAHOO.widget.AutoComplete('classification_1', 'classification_1Container', oDS, oConfigs);
        var oAC2 = new YAHOO.widget.AutoComplete('classification_2', 'classification_2Container', oDS, oConfigs);
        
        oAC.useShadow = true;
        oAC1.useShadow = true;
        oAC2.useShadow = true;
        
        oAC.generateRequest = function(sQuery) {
	        return 'action=autocomplete&module=Leads&to_pdf=true&classification='+sQuery;
	    };
        oAC1.generateRequest = function(sQuery) {
	        return 'action=autocomplete&module=Leads&to_pdf=true&classification='+sQuery;
	    };
        oAC2.generateRequest = function(sQuery) {
	        return 'action=autocomplete&module=Leads&to_pdf=true&classification='+sQuery;
	    };
        
        return {
            oDS: oDS,
            oAC: oAC,
            oAC1: oAC1,
            oAC2: oAC2
        };
       }();
        });
        </script>
EOQ;
        
        echo <<<EQQ
   <script type='text/javascript' src="include/javascript/overlibmws.js"></script>
   <script type='text/javascript'>
      var pull_from_menu = '$pull_from_menu';
      var min_one_bidder = $min_one_bidder;     
      
      var selectedCounty = JSON.parse('$SELECTED_COUNTIES');
		
      YUI().use('node-base','io',"selector-css3",'event',function (Y){
      		
      		function loadCounties(){ 
      			
      			ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
      			
      			postParam = new Array;
      			
      			postParam  = $('#state_advanced').val();
      			
      			if(postParam != null){
	      			
      				//get Counties
					var callback = {
					    success:function(o){
      		
      							$('#county_id_advanced').html(o.responseText);       							
								
      		
							}
					};
      				
					stPostState	= '&state_advacne[]='+postParam.join('&state_advacne[]=');
					stPostState	= '&county_id[]='+selectedCounty.join('&county_id[]=');
					var connectionObject = YAHOO.util.Connect.asyncRequest ("POST", "index.php?entryPoint=CountyAjaxCall&multisel=1&to_pdf=1&state_advacne[]="+postParam.join('&state_advacne[]='), callback,stPostState);
      			}
      			ajaxStatus.hideStatus();
        	}
      		

      		if( Y.one('select[name^=state_advanced]') != null){     		
        		Y.on('load',function(){loadCounties()})
        		Y.one('select[name^=state_advanced]').on('change',function(e){
					loadCounties();    
				});				
			}
      });
      
      
       /* 
      	* Not working in IE
      	*
        	function loadCounties(){ 
        	ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));       
        		postParam = new Array;
        		Y.all('select[name^=state_advanced] option').each(function (elm){ 
						if(elm.get('selected')){
        					postParam.push(elm.get('value'));
							}
				});	
				//get Counties
				var callback = {
				    success:function(o){        							
        					county = YAHOO.util.Selector.query('select[name^=county_id_advanced]'); 
        					county[0].innerHTML= o.responseText;       							
							ajaxStatus.hideStatus();
							}
							};
					stPostState	= '&state_advacne[]='+postParam.join('&state_advacne[]=');
					stPostState	= '&county_id[]='+selectedCounty.join('&county_id[]=');
					var connectionObject = YAHOO.util.Connect.asyncRequest ("POST", "index.php?entryPoint=CountyAjaxCall&multisel=1&to_pdf=1&state_advacne[]="+postParam.join('&state_advacne[]='), callback,stPostState);
        		}
        		
        	if( Y.one('select[name^=state_advanced]') != null){     		
        		Y.on('load',function(){loadCounties()})
        		Y.one('select[name^=state_advanced]').on('change',function(e){
					loadCounties();    
				});				
			}
		});
       */

        YAHOO.util.Event.onDOMReady(function(){
        var container1 = document.createElement('div');
        container1.innerHTML = '';  
        container1.id = 'classificationBasicContainer';
        
        var container2 = document.createElement('div');
        container2.innerHTML = '';  
        container2.id = 'classificationAdvancedContainer';      
        

            YAHOO.util.Dom.insertAfter(container1 ,YAHOO.util.Dom.get('classification_basic'));
            YAHOO.util.Dom.insertAfter(container2 ,YAHOO.util.Dom.get('classification_advanced'));         
            
            YAHOO.example.classification = function() {
        
	var oConfigs = {
            prehighlightClassName: "yui-ac-prehighlight",
            queryDelay: 0,
            minQueryLength: 0,
            animVert: .01,
            useIFrame: true
        }
        
        // instantiate remote data source
        var oDS = new YAHOO.util.XHRDataSource("index.php?"); 
        oDS.responseType = YAHOO.util.XHRDataSource.TYPE_HTMLTABLE; 
        oDS.responseSchema = { 
           fields: ["name"]            
        };
        
        oDS.maxCacheEntries = 10;         
    
        var oAC = new YAHOO.widget.AutoComplete("classification_basic", "classificationBasicContainer", oDS, oConfigs);
        var oAC1 = new YAHOO.widget.AutoComplete("classification_advanced", "classificationAdvancedContainer", oDS, oConfigs);
        
                
        oAC.useShadow = true;
        oAC1.useShadow = true;
        
        
        oAC.generateRequest = function(sQuery) { 
	        return "action=autocomplete&module=Leads&to_pdf=true&classification="+sQuery;
	    }; 
        oAC1.generateRequest = function(sQuery) { 
	        return "action=autocomplete&module=Leads&to_pdf=true&classification="+sQuery;
	    };    
            
        return {
            oDS: oDS,
            oAC: oAC,
            oAC1: oAC1            
        };
       }();             
       
        });
		
      	var mySimpleDialog2 ='';
		function getSimpleDialog2(params){	
			if (typeof(mySimpleDialog2) != 'undefined' && mySimpleDialog2 != ''){		
				mySimpleDialog2.destroy();		 
			}
				mySimpleDialog2 = new YAHOO.widget.SimpleDialog(params.id, { 
			    width: params.width+'px', 
			    effect:{
			        effect: YAHOO.widget.ContainerEffect.FADE,
			        duration: 0.25
			    }, 
			    fixedcenter: true,
			    modal: true,
			    visible: false,
			    draggable: true
			});
			    
			mySimpleDialog2.setHeader(params.message);
			mySimpleDialog2.cfg.setProperty('icon', YAHOO.widget.SimpleDialog.ICON_WARN);
			return mySimpleDialog2;
		}
      		
      

        /*
      	* to center the popup commented this code 
      	*/
      		function open_urls(event,URL,titleName){	
              
 			target = event.target?event.target:event.srcElement;
            plid = target.id;
            //cont = document.getElementById('url'+plid);
           	if(titleName.indexOf('Online Plan'))
            {
              //	SUGAR.ajaxUI.showLoadingPanel();
              	popupWidth = '99%'
                popupheight = '485'
             }else{ 	
              popupWidth = '555px'; 
              popupheight = 'auto'
             } 
              	
            if(false && cont.innerHTML != '')
            {
              //  showPopup(cont.innerHTML,titleName,popupWidth);
              //  SUGAR.util.evalScript(cont.innerHTML);

            }else{
              
			ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
            var sUrl = URL;
            var callback = {
                    success: function(o) {                    
		                document.getElementById('url'+plid).innerHTML = o.responseText;                        
		                document.getElementById('url'+plid).style.display='none';
						showPopup(o.responseText,titleName,popupWidth,popupheight);
						ajaxStatus.hideStatus();
						SUGAR.util.evalScript(o.responseText);
		            },
                    failure: function(o) {
                    
                    }
                }

                var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);
            }
        }
        
        
function showPopup(txt,TitleText,width,height){
              
              
              TitleText=	decodeURIComponent(TitleText).replace(/\+/g, ' ');
              
              
              
              oReturn = function(body, caption, width, theme) {
                                        $(".ui-dialog").find(".open").dialog("close");
                                        var bidDialog = $('<div class="open"></div>')
                                        .html(body)
                                        .dialog({
              									model:true,
                                                autoOpen: false,
                                                title: caption,
                                                width: width,
              									height : height,
              									//show: "slide",
              				//hide: "scale",                                                
                                        });
                                        bidDialog.dialog('open');

                                };
       
oReturn(txt,TitleText, width, '');
                                                
return;
        
}

		
// Pull project lead through AJAX

 YAHOO.util.Event.onDOMReady(function(){
//Create a YUI instance using io-base module.

YUI().use("io-base","node", function(Y) {

	Y.one("#pull_leads").on('click',function(){
    	min_one_bidder=0;
    	initiatePulling();
    });
	Y.one("#pull_leads_ico").on('click',function(){
    	min_one_bidder=0;
    	initiatePulling();
    });
	
	if(pull_from_menu==1){	        	
	    initiatePulling();  		    	
	}

	if(min_one_bidder==1){
    	initiatePulling();
    }
    
    function checkProcessStatus(){
		var uri = "cmdscripts/process_status.php";
		var cfg = {
	    method: 'POST',
	    data: 'user=yahoo',
	    headers: {
	        'Content-Type': 'application/json',
	    },
	    on: {
	        start: function(){
    			
    		},
	        complete:function(id,o){		        		        				
						var res = o.responseText;       					
        				var res_str = res.split('_');
        				var import_text_arr = res_str[1].split('|');
        				var inserted_pl = trim(import_text_arr[0]);
        				var updated_pl = trim(import_text_arr[1]);        				      					
        				if(inserted_pl == '0' && updated_pl == '0'){
    						var msg_text = 'Data streaming is in progress...';        					
    					}else{
    						var msg_text = 'Project Lead Imported: '+inserted_pl+' Project Lead Updated: '+updated_pl;
    					}         				
        				if(trim(res_str[0])=='running'){       						
        					ajaxStatus.showStatus(msg_text);
        					return true;
            			}else if(trim(res_str[0])=='finished'){							
        					ajaxStatus.showStatus(inserted_pl+' Project Lead Imported and '+ updated_pl +' Project Lead Updated Successfully.');
        					setInterval(function(){    							
        						window.location.href="index.php?module=Leads&action=index&n=" + new Date().getTime();;	
    						},5000);
        					
							return false;
						}       			       				       				
        				
		        	},
	        end: function(){   					
    		}
	    }	    
	    
	};    
    var request = Y.io(uri,cfg);
		
	}   
    
    
	function initiatePulling(){
		
	var isSuccess=false;	
    //var uri = "index.php?entryPoint=PullProjectLeadsNew&lead_count=1&one_bidder="+min_one_bidder;
	//var uri = "index.php?entryPoint=ProjectLeadDirectInsert&one_bidder="+min_one_bidder;
	//var uri = "index.php?entryPoint=PullLeadCommand&one_bidder="+min_one_bidder;
	//var uri = "index.php?entryPoint=PullBBH&process=getLeads";	
	var uri = "cmdscripts/PullBBHCommand.php";

    // Define a function to handle the response data.
       var cfg = {
	    method: 'POST',
	    data: 'user=yahoo',
	    headers: {
	        'Content-Type': 'application/json',
	    },
	    on: {
	        start: function(){
    			ajaxStatus.showStatus("Please wait while populating leads...");
    		},
	        complete:function(id,o){
		        		//how many project leads we have        				
        				//var res = JSON.parse(o.responseText);
						var res = o.responseText;
        				var res = trim(res);			
        				if(res=='success'){							
							window.location.href="index.php?module=Leads&action=index";
            			}else if(res=='start'){
							ajaxStatus.showStatus('Please wait while populating leads...');
							setInterval(function(){checkProcessStatus()},5000);							
							return false;
						}else if(res=='running'){
							ajaxStatus.showStatus('Please wait while populating leads...');
							setInterval(function(){checkProcessStatus()},5000);							
							return false;    
    					}else{
							ajaxStatus.showStatus(res);
							return false;    
						}

            			/* if(res.status=='success'){            				
            				ajaxStatus.showStatus("Please wait while populating leads...");
            				getProjectLead(res.total_leads);            					
                		} */        				       				
        				
		        	},
	        end: function(){   					
    		}
	    }
	    
	    
	};    
    var request = Y.io(uri,cfg);
	}

	function getProjectLead(totalLeads){
		// Create a YUI instance using the io queue sub-module.
		
		YUI().use("io-queue", function(Y) {

			var uri = "index.php?entryPoint=PullProjectLeadsNew&one_bidder="+min_one_bidder;
			
		    // Stop the queue so transactions can be stored.
		    Y.io.queue.stop();

		    // Send four transactions into the queue. Each response will arrive
		    // in synchronous order.
		    	    
			var configuration = {
    			on: {
        			complete: function(o) {            
        				//window.location.href="index.php?module=Leads&action=index";	
    				},
    			},
			};
			
			var loopCount = Math.ceil(totalLeads/5);
			//var loopCount = totalLeads;
			var loopCount1 = loopCount-1;			
		    for(var i=0;i<loopCount1;i++){    			
			    eval('var task'+i+' = Y.io.queue(uri);');		    			    	
		    }
		    	eval('var task'+loopCount+' = Y.io.queue(uri,configuration);');		    
		    		    
		    Y.io.queue.start();	    
		    	    
		});
	}

});

});

var mySimpleDialog ='';
function getSimpleDialog(params){	
	if (typeof(mySimpleDialog) != 'undefined' && mySimpleDialog != ''){		
		mySimpleDialog.destroy();		 
	}
		mySimpleDialog = new YAHOO.widget.SimpleDialog(params.id, { 
	    width: params.width+'px', 
	    effect:{
	        effect: YAHOO.widget.ContainerEffect.FADE,
	        duration: 0.25
	    },
	    //fixedcenter: true,
        x: params.x,
        y: 40,
	    modal: true,
	    visible: false,
	    draggable: true
	});
	    
	mySimpleDialog.setHeader(params.message);
	mySimpleDialog.cfg.setProperty('icon', YAHOO.widget.SimpleDialog.ICON_WARN);
	return mySimpleDialog;
}

var mySimpleDialog1 ='';
function getSimpleDialog1(params){	
	if (typeof(mySimpleDialog1) != 'undefined' && mySimpleDialog1 != ''){		
		mySimpleDialog1.destroy();		 
	}
		mySimpleDialog1 = new YAHOO.widget.SimpleDialog(params.id, { 
	    width: params.width+'px', 
	    effect:{
	        effect: YAHOO.widget.ContainerEffect.FADE,
	        duration: 0.25
	    }, 
	    //fixedcenter: true,
        x: params.x,
        y: 40,
	    modal: true,
	    visible: false,
	    draggable: true		
	});
	    
	mySimpleDialog1.setHeader(params.message);
	mySimpleDialog1.cfg.setProperty('icon', YAHOO.widget.SimpleDialog.ICON_WARN);
	return mySimpleDialog1;
} 
                		
     function showPopupBidBoard(lead_id){
        $('#dlg1').find('.container-close').remove();
		var params = Array();
		params['id'] = 'dlg1';
		params['message'] = 'Bid Board Updates';
		params['width'] = '990';
        //start -- center the modal
        var windowWidth = $(window).width();
        var blankPosition = parseInt(windowWidth) -  parseInt(params['width']);
        if(blankPosition > 0){
            var xCoordinate = (blankPosition / 2);
            params['x'] = xCoordinate;
	    }
        //end -- center the modal
		mySimpleDialog = getSimpleDialog(params);						 
		mySimpleDialog.setBody('Loading...');	      
	    mySimpleDialog.render(document.body);			
	    mySimpleDialog.show();
		
		var callback = {
    		success:function(o){    			
				mySimpleDialog.setBody(o.responseText);
    		}
    	}
		YAHOO.util.Connect.asyncRequest ('GET', 'index.php?module=Leads&action=relatedpl&to_pdf=true&lead_id='+lead_id, callback);
	    return false;	       
    }
		
	function showPLDetailModal(lead_id){   	
        ajaxStatus.showStatus('Loading...');
        
		var callback = {
    		success:function(o){	
                ajaxStatus.hideStatus();		
                showPopup(o.responseText,'Project Lead Details','98%');
                /*iList = $('input[value='+lead_id+']').parent();
                obAllTd = $(iList).siblings();
                obAllTd.each(function(i,e){
                val = $(e).html();
                if(val.trim() == 'New'){ 
                    $(e).html('Viewed')
                }
                })*/
                val=$('#status_'+lead_id).html();
                val=(val=='New')?'Viewed':val;
                $('#status_'+lead_id).html(val);
    		}
    	}
		YAHOO.util.Connect.asyncRequest ('GET', 'index.php?module=Leads&action=pldetails&to_pdf=true&lead_id='+lead_id, callback);
		return false;
    }
		
</script>	
   
EQQ;
    }

    function getModuleTitle($show_help = true) {
        //parent::getModuleTitle($show_help);

        global $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $action;

        $theTitle = "<div class='moduleTitle'>\n<h2>";

        $module = preg_replace("/ /", "", $this->module);

        $params = $this->_getModuleTitleParams();
        $count = count($params);
        $index = 0;

        if (SugarThemeRegistry::current()->directionality == "rtl") {
            $params = array_reverse($params);
        }

        foreach ($params as $parm) {
            $index++;
            $theTitle .= $parm;
            if ($index < $count) {
                $theTitle .= $this->getBreadCrumbSymbol();
            }
        }
        $theTitle .= "</h2>\n";

        if ($show_help) {
            $theTitle .= "<span class='utils'>";

            $createImageURL = SugarThemeRegistry::current()->getImageURL('create-record.gif');
            $theTitle .= <<<EOHTML
<a href="javascript:void(0);" id="pull_leads_ico"><img src='{$createImageURL}' alt='{$GLOBALS['mod_strings']['LNK_PULL_PROJECT_LEADS']}'></a>
<a href="javascript:void(0);" class="utilsLink" id="pull_leads">{$GLOBALS['mod_strings']['LNK_PULL_PROJECT_LEADS']}</a>&nbsp;
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
<img src='{$createImageURL}' alt='{$GLOBALS['app_strings']['LNK_CREATE']}'></a>
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
{$GLOBALS['app_strings']['LNK_CREATE']}
</a>
EOHTML;
        }

        $theTitle .= "</span></div>\n";
        return $theTitle;
    }

    /**
     * Overriden method prepareSearchForm to change the searchform class
     * @added BY : Ashutosh
     * @date : 16 Sept 2013
     * @see SugarView::prepareSearchForm()
     */
    function prepareSearchForm()
    {
        $this->searchForm = null;
    
        //search
        $view = 'basic_search';
        if(!empty($_REQUEST['search_form_view']) && $_REQUEST['search_form_view'] == 'advanced_search')
            $view = $_REQUEST['search_form_view'];
        $this->headers = true;
    
        if(!empty($_REQUEST['search_form_only']) && $_REQUEST['search_form_only'])
            $this->headers = false;
        elseif(!isset($_REQUEST['search_form']) || $_REQUEST['search_form'] != 'false')
        {
            if(isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'advanced_search')
            {
                $view = 'advanced_search';
            }
            else
            {
                $view = 'basic_search';
            }
        }
    
        $this->use_old_search = true;
        if ((file_exists('modules/' . $this->module . '/SearchForm.html')
                && !file_exists('modules/' . $this->module . '/metadata/searchdefs.php'))
                || (file_exists('custom/modules/' . $this->module . '/SearchForm.html')
                        && !file_exists('custom/modules/' . $this->module . '/metadata/searchdefs.php')))
        {
            require_once('include/SearchForm/SearchForm.php');
            $this->searchForm = new SearchForm($this->module, $this->seed);
        }
        else
        {
            $this->use_old_search = false;
            require_once('custom/include/SearchForm/SearchForm2.php');
    
            $searchMetaData = SearchForm::retrieveSearchDefs($this->module);
            /**
             * Applied the new method getPlOppSearchForm2 to override the searchform2.php
             * @Added By : Ashutosh
            * @date : 16 Sept 2013*/
            $this->searchForm = $this->getPlOppSearchForm2($this->seed, $this->module, $this->action);
            $this->searchForm->setup($searchMetaData['searchdefs'], $searchMetaData['searchFields'], 'SearchFormGeneric.tpl', $view, $this->listViewDefs);
            $this->searchForm->lv = $this->lv;
        }
    }
    
    
    /**
     * new method to override the searchform2.php
     * @Added By : Ashutosh
     * @date : 16 Sept 2013
     * @param Object $seed
     * @param object $module
     * @param string $action
     * @return PlOppSearchForm
     */
    protected function getPlOppSearchForm2($seed, $module, $action = "index"){
    
        return new PlOppSearchForm($seed, $module, $action);
    
    }
    
}

?>
