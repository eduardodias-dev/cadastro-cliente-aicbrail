SELECT a.id id_assinatura, 
		 CONVERT((a.valor * 100), SIGNED) valor,
		 case a.periodicidade
		 	when 'mensal' then 'monthly'
		 	when 'anual' then 'yearly'
		 	ELSE a.periodicidade
		 END periodicidade,
		 quantidade,
		 a.adesao,
		 COALESCE(nullif(a.info_adicional,' '), CONCAT('Assinatura do plano ', p.nome)) info_adicional,
		 a.tipo_pagamento,
		 a.client_id id_cliente,
		 c.nome nome_cliente,
		 c.documento,
		 -- GROUP_CONCAT(DISTINCT ce.endereco) endereco,
		 ce.endereco emails,
		 cen.cep,
		 cen.rua logradouro,
		 cen.numero,
		 cen.complemento,
		 cen.bairro,
		 cen.cidade,
		 cen.estado
	FROM assinatura a
		INNER JOIN plano p ON a.plan_id = p.id
		INNER JOIN cliente c ON c.id = a.client_id
		LEFT JOIN cliente_email ce ON ce.client_id = c.id
		LEFT JOIN cliente_endereco cen ON cen.client_id = c.id 