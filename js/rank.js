// table的id  需要合并的列（从0开始算）
function mergeCell(tableid, cols) {
	var table = document.getElementById(tableid);
	var table_rows = table.rows;
	// 需要合并的列的数组
	cols.forEach((v, k) => {
		// 循环table每一行
		for (let i = 0; i < table_rows.length - 1; i++) {
			// row
			let now_row = table_rows[i];
			let next_row = table_rows[i + 1];

			// col
			let now_col = now_row.cells[v];
			let next_col = next_row.cells[v];

			if (now_col.innerHTML == next_col.innerHTML) {
				// 标记为需要删除
				$(next_col).addClass('remove');
				// 递归判断当前对象时候已经被删除
				setParentSpan(table, i, v);
			}
		}
	})
	$(".remove").remove();
}

// (递归方法，用于多行统计) pram => table表格 当前行 对应的列 
function setParentSpan(table, row, col) {
	var col_item = table.rows[row].cells[col];
	if ($(col_item).hasClass('remove')) {
		setParentSpan(table, --row, col)
	} else {
		col_item.rowSpan += 1;
	}
}
mergeCell('tableid', [0, 1, 2, 6]);
$(window.document).ready(function () {
	$(function () {
		var tbody = window.document.getElementById("tbody-result");
		$.ajax({
			type: "post",
			url: "http://donghang.haoguit.com/rank.php",
			datatype: "json",
			success: function (msg) {
				var str = "";
				console.log(msg);
				var json_str = JSON.parse(msg);
				console.log(json_str);
                var p = 0;
				for (var i = 0; i < json_str.length; i++) {

                  p++;
					for (var j = 0; j < json_str[i].user.length; j++) {
						str += "<tr>" +
							"<td align='center'>" + p + "</td>" +
							"<td align='center'>" + json_str[i].num + "</td>" +
							"<td align='center'>" + json_str[i].user[j].meeting + "</td>" +
							"<td align='center'>" + json_str[i].user[j].username + "</td>" +
							"<td align='center'>" + json_str[i].user[j].number + "</td>" +
							"<td align='center'>" + json_str[i].user[j].date + "</td>" +
							"<td align='center'>" + json_str[i].timezone + "</td>" +
							"</tr>";
					}
				}
				tbody.innerHTML = "<tr><td>总排名</td><td>总分</td><td>单位</td><td>姓名</td><td>单轮最高分</td><td>单轮耗时（秒）</td><td>总耗时（秒）</td></tr> " + str;
				mergeCell('tableid', [0, 1, 2, 6]);
			},
			error: function () {
				alert("查询失败")
			}

		});
	});

});