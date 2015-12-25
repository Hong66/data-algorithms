<?php
/**
 * 二叉树 求最低公共祖先 ( LCA - Lowest Common Ancestor ) 
 *
 * 实现的思路如下：
 * 		1, 得到从 root 到 node1 的路径 path1, 并将其存储在一个数组中,
 * 		2, 得到从 root 到 node2 的路径 path2, 并将其存储在一个数组中,
 * 		3, 遍历两个路径数组, 直至遇到两个路径的当前节点互不相同, 
 * 		   那么前一个节点就是 node1, node2 的最低公共祖先。
 *
 * @author  Hong <skywalkerhong88@gmail.com>
 */

class Node
{
	public $key;
	public $left,$right;
}

class Generator
{
	/**
	 * [创建一个新的节点]
	 * @param  [int] $key [ 节点的值 ]
	 * @return [object] $node [ 返回一个新的节点 ]
	 */
	public function createNode($key)
	{
		$node = new Node();
		$node->key = $key;
		$node->left = $node->right = null;

		return $node;
	}
}

class LCA 
{
	/**
	 * [查找路径]
	 * @param  [object] $root [根节点]
	 * @param  [path] &$path [路径]
	 * @param  [int] $key [节点值]
	 * @return [bool]     [是否存在]
	 */
	public function findPath($root, &$path, $key)
	{
		if ( $root == null ) {
			return false;
		}
		$path[] = $root->key;
		if ($root->key == $key) {
			return true;
		}
		// 递归
		// 将这个步骤想像成找路, 找错了就返回到上一个节点
		$find = ( $this->findPath($root->left, $path, $key) || $this->findPath($root->right, $path, $key) );

		if ($find) {
			return true;
		}
		array_pop($path);
		return false;
	}

	/**
	 * [寻找 lowest common ancestor 方法一]
	 * @param  [object] $root [根节点]
	 * @param  [int] $key1 [node1 的值]
	 * @param  [int] $key2 [node2 的值]
	 * @return [int]       [LCA 值]
	 */
	public function findLCA($root, $key1, $key2)
	{
		$path1 = array();
		$path2 = array();
		$res1 = $this->findPath($root, $path1, $key1);
		$res2 = $this->findPath($root, $path2, $key2);

		if ($res1 && $res2) {
			$ans;
			for($i=0; $i<count($path1); $i++) 
			{
				if ( $path1[$i] != $path2[$i] ) {
					break;
				}
				$ans = $path1[$i];
			}
			return $ans;
		}
		return -1;
	}

	/**
	 * [寻找 lowest common ancestor 方法二 , 简单但有局限]
	 * @param  [object] $root [根节点对象]
	 * @param  [int] $key1 [node1 的值]
	 * @param  [int] $key2 [node2 的值]
	 * @return [object]       [LCA 节点]
	 */
	public function findLCA2($root, $key1, $key2) 
	{
		if ($root == null) {
			return null;
		}
		if ($root->key == $key1 || $root->key == $key2) {
			return $root;
		}
		$left_lca = $this->findLCA2($root->left, $key1, $key2);
		$right_lca = $this->findLCA2($root->right, $key1, $key2);

		if ($left_lca && $right_lca) {
			return $root;
		}

		return ($left_lca != null) ? $left_lca : $right_lca;
	}
}

// 创建测试用的二叉树
$Generator = new Generator;
$root = $Generator->createNode(1);
$root->left = $Generator->createNode(2);
$root->right = $Generator->createNode(3);
$root->left->left = $Generator->createNode(4);
$root->left->right = $Generator->createNode(5);
$root->right->left = $Generator->createNode(6);
$root->right->right = $Generator->createNode(7);

// 测试示例
$LCA = new LCA();

echo "LCA(4,5) = ". $LCA->findLCA($root, 4, 5).PHP_EOL;

$res = $LCA->findLCA2($root, 2, 4);
echo "LCA(2,4) = ".$res->key;




?>