@extends('admin_layout')
@section('admin_content')
    <div class="container-fluid">
        <style type="text/css">
            p.title_thongke {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
            }
        </style>

    <div class="row">
        <p class="title_thongke">Thống kê doanh số</p>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
                <input type="text" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
            </div>
            <div class="col-md-2">
                <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>
                    Lọc theo:
                    <select class="dashboard-filter form-control">
                        <option>---Chọn---</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
                        <option value="nam">Năm</option>
                    </select>
                </p>
            </div>
        </form>

        <div class="col-md-12">
            <div id="chart" style="height:250px;"></div> 
        </div>
    </div>
    <div class="row">
        <style type="text/css">
            table.table.table-bordered.table-dark {
                background: #32383e;
            }
            table.table.table-bordered.table-dark tr th {
                color: #fff;
            }
        </style>
        <p class="title_thongke">Thống kê truy cập</p>
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col">Đang online</th>
                    <th scope="col">Tổng tháng trước</th>
                    <th scope="col">Tổng tháng này</th>
                    <th scope="col">Tổng một năm</th>
                    <th scope="col">Tổng truy cập</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$visitor_count}}</td>
                    <td>{{$visitor_lastmonth_count}}</td>
                    <td>{{$visitor_thismonth_count}}</td>
                    <td>{{$visitor_year_count}}</td>
                    <td>{{$visitors_total}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <p class="title_thongke">Thống kê web</p>
            <div id="donut" class="morris-donut-inverse"></div>
        </div>
    </div>
</div>
@endsection
