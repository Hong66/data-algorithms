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
	 * @param  [int] 	$key 	[ 节点的值 ]
	 * @return [object] $node   [ 返回一个新的节点 ]
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
		$find = ( $this->findPath($root->left, $path, $key) || $this->findPath($root->right, $path, $key) );

		if ($find) {
			return true;
		}
		array_pop($path);
		return false;
	}

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

echo "LCA(4,5) = ".$LCA->findLCA($root, 4, 5);


?>