<? //���������� �������

	function update_Goods_Count_Value_For_Categories($parent) { //�������� �� ���� ���������� � ��������� �������� GoodsCount ��� ������ ���������.
											//��������� ����������� � ���� ������

		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$parent." ORDER BY Name;") or die (mysql_error());
		$goods_count = 0;

		while ($row = mysql_fetch_row($q)) {

			//���������� ��� ������������ ������

			//���-�� ������� � ������ �������� ($goods_count) ����� ������������ �� ���-�� ������� � �� �������������: ...
			$goods_count += update_Goods_Count_Value_For_Categories($row[0]);

		};

		//...� �� ���-�� ������� � ����� ���������:
		$p = mysql_query("SELECT * FROM GoodsList WHERE CID=".$parent) or die (mysql_error());
		while (mysql_fetch_row($p)) $goods_count++;

		//��������� ����������� � ��
		if ($parent)
			mysql_query("UPDATE Categories SET GoodsCount=".$goods_count." WHERE CID=".$parent) or die (mysql_error());

		return $goods_count;

	};


?>