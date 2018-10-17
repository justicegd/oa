<form action="{{route('addOa')}}" method="post">
    @csrf
    <table>
        <tr>
            <td>回传讯息</td>
            <td>{!! $msg or '' !!}</td>
        </tr>
        <tr>
            <td>任务阵列</td>
            <td>
                <textarea name="oaData" style="height:545px;width: 1318px">
                </textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td ><input type="submit" value="送出"></td>
        </tr>
    </table>


</form>