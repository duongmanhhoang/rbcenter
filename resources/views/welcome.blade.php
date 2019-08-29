<div class="form-group m-form__group" id="m_repeater_1">
    <label>Chọn ngày học </label>
    <div>
        <div data-repeater-list="" class="col-lg-10">
            <div data-repeater-item class="row" style="margin-bottom: 20px">
                <div class="col-md-6" style="padding-left: 0">
                    <input type="text" class="form-control m-input my-datetimepicker"
                           placeholder="Chọn thời gian lớp học" name="timetable[]">
                    @if($errors->has('timetable'))
                        <p class="text-danger">{{$errors->first('timetable')}}</p>
                    @endif
                    <div class="d-md-none m--margin-bottom-10"></div>
                </div>


                <div class="col-md-4">
                    <div data-repeater-delete=""
                         class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>Xóa</span>
																</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="m-form__group form-group row">
        <div data-repeater-create=""
             class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>Thêm</span>
														</span>

        </div>
    </div>
</div>



<div class="form-group m-form__group">
    <label>Chọn học sinh</label>
    <div class="col-6">
        <select class="form-control m-select2" id="student_code" multiple
                name="student_code[]">
            <option></option>
            @foreach($students as $student)
                <?php
                    $api = new App\Api\Api();
                    $student_info = $api->sendRequest('get', 'api/student-info/'.$student->id)->data;
                ?>
                <option value="{{$student_info->student_code}}">{{$student_info->student_code}} ({{$student->full_name}})</option>
            @endforeach
        </select>
    </div>
</div>