<script type="text/javascript">
  var Slides = new Array();
<?php
$i=0;
foreach ($slides as $slide) {
?>
  Slides[<?php echo($i) ?>] = new Array();
  Slides[<?php echo($i) ?>].id = <?php echo(addslashes($slide->id)) ?>;
  Slides[<?php echo($i) ?>].title = '<?php echo(addslashes($slide->title)) ?>';
  Slides[<?php echo($i) ?>].section = '<?php echo(addslashes($slide->section)) ?>';
  Slides[<?php echo($i) ?>].uselink = '<?php echo(addslashes($slide->uselink)) ?>';
  Slides[<?php echo($i) ?>].slide_order = '<?php echo(addslashes($slide->slide_order)) ?>';
  Slides[<?php echo($i) ?>].date = '<?php echo(date("Y-m-d", strtotime($slide -> modified))) ?>';
  Slides[<?php echo($i) ?>].image = '<?php echo(addslashes( $this -> Html -> image_url($slide -> image))) ?>';
  Slides[<?php echo($i) ?>].thumb = '<?php echo(addslashes( $this -> Html -> image_url($this->Html->thumbname($slide->image)))) ?>';
  
<?php
$i++;
}
?>
//<![CDATA[ 

function Main($scope) {
    $scope.items = [];
    
    var counter = 0;
    $scope.loadMore = function() {
        for (var i = 0; i < 5; i++) {
            $scope.items.push({
              id: Slides[counter].id,
              title: Slides[counter].title,
              thumb: Slides[counter].thumb,
              section: Slides[counter].section,
              slide_order: Slides[counter].slide_order,
              date: Slides[counter].date,
              uselink: Slides[counter].uselink,
              image: Slides[counter].image
            });
/*            $scope.items.push({id: Slides[counter].id});
            $scope.items.push({thumb: Slides[counter].thumb});
            $scope.items.push({image: Slides[counter].image});*/
            counter += 1;
        }
    };
    
    $scope.loadMore();
    
    $scope.hover = false;
    $scope.onhover = function (e) {
      this.hover = e.type === 'mouseover';
    };

}

angular.module('scroll', []).directive('whenScrolled', function() {
    return function(scope, elm, attr) {
        var raw = elm[0];
        
        elm.bind('scroll', function() {
            if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                scope.$apply(attr.whenScrolled);
            }
        });
    };
});

//]]>  

</script>