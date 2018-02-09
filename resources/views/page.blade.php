@extends('layouts.app')
@section('content')
<div class="container" ng-controller="AdminController">
   <center>
      <h2>List Members</h2>
   </center>
   <table class="table table-bordered">
      <thead>
         <tr>
            <th ng-click="sortData('id')" style="width:20px">ID<div ng-class="getSortClass('id')"></div></th>
            <th ng-click="sortData('name')">Name <div ng-class="getSortClass('name')"></div></th>
            <th ng-click="sortData('address')">Address <div ng-class="getSortClass('address')"></div></th>
            <th ng-click="sortData('age')">Age <div ng-class="getSortClass('age')"></div></th>
            <th width="80px">Photo</th>
            <th style="text-align: center;" width="50px"><a href="" id="add-member" class="btn btn-primary btn-xs" ng-click="modal('add')">Add members</a></th>
         </tr>
      </thead>
      <tbody>
         <tr ng-repeat="post in posts | orderBy:sortColumn:reverse">
            <td><% post.id %></td>
            <td style="word-break: break-all;"><% post.name %></td>
            <td style="word-break: break-all;"><% post.address %></td>
            <td><% post.age %></td>
            <td><img src="/images/<% post.photo || notimg.png %>" style="width: 150px;height: 100px;object-fit: contain;"></td>
            <td>
               <button class="btn btn-default btn-xs btn-detail" id="btn-edit" ng-click="modal('edit',post.id)">Edit</button>
               <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(post.id)">Delete</button>
            </td>
         </tr>
      </tbody>
   </table>
   <div data-pagination="" data-num-pages="numPages()" 
  data-current-page="currentPage" data-max-size="maxSize"  
  data-boundary-links="true"></div>
   <!-- Modal -->
   <div class="modal fade" tabindex="-1" role="dialog" id="Members">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title"><% frmTitle %></h4>
            </div>
            <div class="modal-body">
               <form id="FrmMember" name="frmMember" class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" ng-model="members.name" ng-maxlength="100" ng-required="true" />
                        <div ng-show="frmMember.name.$dirty && frmMember.name.$invalid">
                            <span class="help-block name" ng-show="frmMember.name.$error.required" style="color: red;">Please enter name</span>
                            <span class="help-block name" ng-show="frmMember.name.$error.maxlength" style="color: red;">Words must be less than 100</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
                     <div class="col-sm-9">
                        <!-- <input type="text" class="form-control" id="address" name="address" ng-model="members.address" ng-maxlength="300" ng-required="true" /> -->
                        <textarea id="address" class="form-control" name="address" ng-model="members.address" ng-maxlength="300" ng-required="true"></textarea>
                        <div ng-show="frmMember.address.$dirty && frmMember.address.$invalid">
                            <span class="help-block address" ng-show="frmMember.address.$error.required" style="color: red;">Please enter Address</span>
                            <span class="help-block address" ng-show="frmMember.address.$error.maxlength" style="color: red;">Words must be less than 300</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Age</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" id="age" name="age" ng-model="members.age" ng-maxlength="2" ng-required="true" >
                        <div ng-show="frmMember.age.$dirty && frmMember.age.$invalid">
                            <span id="helpBlock2" class="help-block age" ng-show="frmMember.age.$error.required" style="color: red;">Please enter age</span>
                            <span class="help-block age" ng-show="frmMember.age.$error.maxlength" style="color: red;">The age may not be greater than 2 numeral</span>
                            <span class="help-block age" ng-show="frmMember.age.$error.number" style="color: red;">Not valid number</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label">Photo</label>
                     <div class="col-sm-9">
                        <input type="file" ng-click="clear()"  id="photo" name="photo" file-model="myFile" ngf-model-invalid="errorFile" ngf-max-size="10MB" ngf-pattern="'.jpg,.png,.gif'" ngf-accept="'.jpg,.png,.gif'"  ngf-select ng-model="myFile" id="upload" ngf-change="upload($files, $file, $newFiles, $duplicateFiles, $invalidFiles, $event)"/>
                        <div ng-show="frmMember.photo.$dirty && frmMember.photo.$invalid">
                            <span class="help-block photo " ng-show="frmMember.photo.$error.maxSize" style="color: red;">File too large max: 10MB</span>
                            <!-- <img ng-show="frmMember.photo.$valid" ngf-thumbnail="myFile" class="thumb" style="margin-top:5px;width: 100px;height: 100px;object-fit: contain;"> -->
                            <span  class="help-block photo" style ="color: red;" ng-show="frmMember.photo.$error.pattern">Image only support: png; jpeg; gif.</span>
                        </div>
                        <span style="color: red;" id="error"><% messages %></span>
                     </div>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" ng-disabled="frmMember.$invalid" ng-click="save(status,id)">Save</button>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection