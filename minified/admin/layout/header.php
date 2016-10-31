<?php
/**
 * Created by PhpStorm.
 * User: Abdelqader Osama
 * Date: 10/31/16
 * Time: 2:31 PM
 */

include_once('_additional.php');
?><!DOCTYPE html>
<html>
<?php include_once(BOTSPATH.'admin/layout/head.php'); ?>
<body class="fixed-left">
<div id="wrapper">
    <div class="topbar">
        <div class="topbar-left">
            <div class="text-center"><a href="index.php" class="logo"><i class="md md-terrain"></i>
                    <span>Bots - Abyd.NET</span></a></div>
        </div>
    </div>
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <div id="sidebar-menu">
                <ul>
                    <?php include_once BOTSPATH.'admin/layout/menu.php' ?>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="content-page">
        <div class="content">
            <div class="container">
