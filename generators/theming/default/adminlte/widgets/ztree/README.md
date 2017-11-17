# yii2-ztree
The zTree extension for the Yii framework 2.0

## Installation

The preferred way to install this extension is through composer.

Either run

``` bash
php composer.phar require --prefer-dist liyuze/yii2-ztree "*"
```
or add
``` bash
"liyuze/yii2-ztree": "*"
```
to the require section of your `composer.json` file.

## Usage

Once the extension is installed, simply use it in your code by :

``` php
<?= \liyuze\ztree\ZTree::widget([
        'setting' => '{
			data: {
				simpleData: {
					enable: true
				}
			}
		}',
        'nodes' => '[
			{ id:1, pId:0, name:"父节点1 - 展开", open:true},
			{ id:11, pId:1, name:"父节点11 - 折叠"},
			{ id:111, pId:11, name:"叶子节点111"},
			{ id:112, pId:11, name:"叶子节点112"},
			{ id:113, pId:11, name:"叶子节点113"},
			{ id:114, pId:11, name:"叶子节点114"},
			{ id:12, pId:1, name:"父节点12 - 折叠"},
			{ id:121, pId:12, name:"叶子节点121"},
			{ id:122, pId:12, name:"叶子节点122"},
			{ id:123, pId:12, name:"叶子节点123"},
			{ id:124, pId:12, name:"叶子节点124"},
			{ id:13, pId:1, name:"父节点13 - 没有子节点", isParent:true}
		]'
    ]);
?>
```

or, standard use it on your code by:

``` php
<?= \liyuze\ztree\ZTree::widget([
		'id' => 'category_tree',	//自定义id
        'setting' => '{
			view: {
				dblClickExpand: false,
				showLine: false
			},
			callback: {
				onClick: onClick
			}
		}',
        'nodes' => '[
			{ name:"父节点1 - 展开", open:true,
				children: [
					{ name:"父节点11 - 折叠",
						children: [
							{ name:"叶子节点111"},
							{ name:"叶子节点112"},
							{ name:"叶子节点113"},
							{ name:"叶子节点114"}
						]},
					{ name:"父节点12 - 折叠",
						children: [
							{ name:"叶子节点121"},
							{ name:"叶子节点122"},
							{ name:"叶子节点123"},
							{ name:"叶子节点124"}
						]},
					{ name:"父节点13 - 没有子节点", isParent:true}
				]
			}
		]'
    ]);
?>

<script>
	function onClick(e,treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandNode(treeNode);
    }
</script>
```

## Extend
[zTree GitHub](https://github.com/zTree/zTree_v3) 
[zTree API](http://www.ztree.me/v3/api.php) 
[zTree Demo](http://www.ztree.me/v3/demo.php)