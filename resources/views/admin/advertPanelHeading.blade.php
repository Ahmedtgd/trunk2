<style type="text/css">
/*   .panel-heading .nav li a:focus {
        background-color: #1abc9c;
        color: #fff;
   }*/
   #adminpanelheading .dropdown-menu li a{ font-size: 16px; }
   #adminpanelheading .nav-tabs li a{
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    .dropdown-toggle{ color: #000; }
    #adminpanelheading .nav .current_nav a{background: #fff; color:#000; font-weight: bold;}
    #adminpanelheading .nav .current_nav a:focus{background: #fff; color:#000; font-weight: bold; cursor: pointer;}
    #adminpanelheading .nav .current_nav a:hover{background: #fff; color:#000; font-weight: bold; cursor: pointer;}
    #adminpanelheading .nav li a{background: #e7e7e7; color:#000;}
    #adminpanelheading .nav li a:focus{background: #e7e7e7; cursor: pointer;}
    #adminpanelheading .nav li a:hover{background: #1abc9c; cursor: pointer; color: #fff;}
    #adminpanelheading .nav li .dropdown-menu li a{background: #fff; color:#000; font-weight: normal;}
    #adminpanelheading .nav li .dropdown-menu li a:hover{background: #1abc9c; color:#fff; font-weight: normal;}
	
	#adminpanel li a {
		border: 1px solid #ddd;
		border-bottom-color: transparent;
	}
	
	#advertpanel li a {
		border: 1px solid #ddd;
		border-bottom-color: transparent;
	}

    #adminpanelheading .nav li a.active{
        background: #1abc9c;
        cursor: pointer;
        color: #fff;
    }
</style>
<br>
<div class="panel-heading" id="adminpanelheading"
	style="font-size: 16px;padding-top:0">
	<h2 class="row">Advertisement Admin Preview</h2>
    <ul class="nav navbar-nav" id="adminpanel" style="margin-left:-15px">
        <li class="dropdown" id="generalad">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0" href="{{ route('advert') }}">
				Landing Page
				&nbsp;&nbsp;
			</a>
        </li>
        <li class="dropdown" id="categoryad">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Category
                <b class="caret"></b>&nbsp;&nbsp; 
              </a>
            <ul class="dropdown-menu categories_list">
                @foreach($categories as $key=>$val)
                    <li data-id="{{$key}}"><a href="{{route('generalAdvertCategory', ['category' => $key])}}">{{$val}}</a></li>
                @endforeach
            </ul>
        </li>
        <li class="dropdown" id="subcatad">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Subcategory
                <b class="caret"></b>&nbsp;&nbsp; 
              </a>
            <ul class="dropdown-menu sub_categories_list">
			@foreach($subCategories as $key=>$val)
                    <li data-id="{{$key}}"><a href="{{route('generalAdvertSubCategory', ['category' => $key])}}">{{$val}}</a></li>
            @endforeach
            </ul>
        </li>
        <li class="dropdown" id="oshopad">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                O-Shop
				<!--
                <b class="caret"></b>
				-->
				&nbsp;&nbsp;  
              </a>
            <ul class="dropdown-menu">
			{{--
                @include('admin/paymentAdminPanel')
			--}}
            </ul>
        </li>
    </ul>
</div>
<br>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#grid').DataTable({
                'scrollX':true,
                 'autoWidth':false
            });

            var url = document.location.href;
            var path = document.location.pathname;
            var res = path.split("/");
			if(res[res.length -1] == "advert"){
				$("#generalad").addClass("current_nav");
			} else {
				if(res[res.length -2] == "category"){
					$("#categoryad").addClass("current_nav");
				}
				if(res[res.length -2] == "subcategory"){
					$("#subcatad").addClass("current_nav");
				}
			}

            //$("#"+res).addClass("current_nav");

    });
    </script>
